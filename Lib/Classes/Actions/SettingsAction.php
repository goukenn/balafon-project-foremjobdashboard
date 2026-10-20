<?php
// @author: C.A.D. BONDJE DOUE
// @file: Settings.phtml
// @desc: view action Settings
// @date: 20250513 21:33:38
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use com\igkdev\projects\ForemJobDashboard\Helpers\TwoFactorAuth;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use IGK\Actions\ActionBase;
use IGK\Models\Users;
use IGK\System\Http\Request;
use IGK\System\Http\RequestResponseCode;

/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions
* @author C.A.D. BONDJE DOUE
*/
class SettingsAction extends ActionBase{
    /**
     * retrive job list
     * @return array{joblist: array}
     */
    public function joblist(?JobUsers $user=null){
        $cur_user = $this->getController()->getUserProfile()->user();
        if (is_null($user) || ($user->id == $cur_user->id)){
        }
        $user = $user ?? $cur_user;
        $condition = ($user)? [
            Jobs::FD_USER_ID=>$user->id
        ]: [];
        $r = Jobs::select_all($condition);
        return $r;
    }

    /**
     * security settings — two-factor authentication enroll/disable. Re-derives the pending
     * enrollment state (QR/secret) from the session on every load, since twofa_generate_post
     * only stashes the secret and redirects back here (POST/redirect/GET).
     * @return array
     */
    public function security(){
        $user = $this->_currentUser();
        $extra = [];
        if (!TwoFactorAuth::IsEnabled($user) && ($secret = igk_app()->session->fjd_pending_2fa_secret ?? null)) {
            $extra = $this->_pendingTwofaPayload($user, $secret);
        }
        return $this->_securityPayload($extra);
    }

    /**
     * generate a pending TOTP secret, stashed in session for the confirmation step. Called
     * from Views/settings/security.phtml via igk_view_handle_actions(), not URL dispatch —
     * see that view's header comment.
     * @return void
     */
    public function twofa_generate_post(){
        $this->_currentUser();
        igk_app()->session->fjd_pending_2fa_secret = TwoFactorAuth::GenerateSecret();
    }

    /**
     * verify the pending secret's code and, on success, persist it as the account's 2FA key.
     * Called from Views/settings/security.phtml via igk_view_handle_actions().
     * @param Request $request
     * @return void
     */
    public function twofa_enable_post(Request $request){
        $user = $this->_currentUser();
        $secret = igk_app()->session->fjd_pending_2fa_secret ?? null;
        $code = (string)$request->get('code');

        if ($secret && TwoFactorAuth::Verify($secret, $code)) {
            $user->update(['auth_2fa_key' => $secret]);
            igk_app()->session->fjd_pending_2fa_secret = null;
        }
    }

    /**
     * disable two-factor authentication for the current account. Called from
     * Views/settings/security.phtml via igk_view_handle_actions().
     * @return void
     */
    public function twofa_disable_post(){
        $user = $this->_currentUser();
        $user->update(['auth_2fa_key' => null]);
    }

    private function _currentUser(): Users
    {
        // NB: getUserProfile()->user() returns this module's own JobUsers profile, not the
        // framework's session Users — auth_2fa_key lives on the latter (see DocsAction::drop_post
        // for the same distinction: $ctrl->getUser() vs JobUsers::GetCache(...)).
        return $this->getUser() ?? igk_die('missing user', true, RequestResponseCode::Forbidden);
    }

    private function _pendingTwofaPayload(Users $user, string $secret): array
    {
        $uri = TwoFactorAuth::GetOtpAuthUri($user, $secret);
        return [
            'twofa_pending_secret' => $secret,
            'twofa_pending_uri' => $uri,
            'twofa_pending_qr' => TwoFactorAuth::BuildQrImageDataUri($uri),
        ];
    }

    private function _securityPayload(array $extra = []): array
    {
        $user = $this->_currentUser();
        return array_merge([
            '_view' => 'settings/security',
            'error' => null,
            'success' => null,
            'twofa_enabled' => TwoFactorAuth::IsEnabled($user),
            'twofa_pending_secret' => null,
            'twofa_pending_uri' => null,
            'twofa_pending_qr' => null,
        ], $extra);
    }
}