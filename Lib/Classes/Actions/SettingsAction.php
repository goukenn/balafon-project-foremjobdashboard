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
     * security settings — two-factor authentication enroll/disable
     * @return array
     */
    public function security(){
        return $this->_securityPayload();
    }

    /**
     * generate a pending TOTP secret and show it (with QR code) for enrollment
     * @return array
     */
    public function twofa_generate_post(){
        $user = $this->_currentUser();
        $secret = TwoFactorAuth::GenerateSecret();
        igk_app()->session->fjd_pending_2fa_secret = $secret;
        return $this->_securityPayload($this->_pendingTwofaPayload($user, $secret));
    }

    /**
     * verify the pending secret's code and, on success, persist it as the account's 2FA key
     * @param Request $request
     * @return array
     */
    public function twofa_enable_post(Request $request){
        $user = $this->_currentUser();
        $secret = igk_app()->session->fjd_pending_2fa_secret ?? null;
        $code = (string)$request->get('code');

        if (!$secret){
            return $this->_securityPayload(['error' => __('Generate a secret first.')]);
        }
        if (!TwoFactorAuth::Verify($secret, $code)){
            return $this->_securityPayload(array_merge(
                ['error' => __('Invalid code. Please try again.')],
                $this->_pendingTwofaPayload($user, $secret)
            ));
        }

        $user->update(['auth_2fa_key' => $secret]);
        igk_app()->session->fjd_pending_2fa_secret = null;

        return $this->_securityPayload(['success' => __('Two-factor authentication enabled.')]);
    }

    /**
     * disable two-factor authentication for the current account
     * @return array
     */
    public function twofa_disable_post(){
        $user = $this->_currentUser();
        $user->update(['auth_2fa_key' => null]);
        return $this->_securityPayload(['success' => __('Two-factor authentication disabled.')]);
    }

    private function _currentUser(): Users
    {
        return $this->getController()->getUserProfile()->user();
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