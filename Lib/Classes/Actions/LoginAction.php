<?php
// @author: C.A.D. BONDJE DOUE
// @file: LoginAction.php
// @desc: login action — password, TOTP 2FA and WebAuthn, ported from the AssimilTraining
//        project's LoginAction
// @date: 20260825 00:00:00
namespace com\igkdev\projects\ForemJobDashboard\Actions;

use com\igkdev\projects\ForemJobDashboard\Helpers\TwoFactorAuth;
use IGK\Actions\ActionBase;
use igk\authentications\WebAuthn\Database\WebAuthnDbUtility;
use IGK\Helper\JSon;
use IGK\System\Http\Request;
use IGK\System\Http\RequestResponseCode;
use IGKEvents;
use lbuchs\WebAuthn\WebAuthn;

/**
 * login action
 * @package com\igkdev\projects\ForemJobDashboard\Actions
 * @author C.A.D. BONDJE DOUE
 */
class LoginAction extends ActionBase
{
    public function index()
    {
        if ($this->getUser()) {
            igk_navto($this->getController()::uri('@/'));
            return;
        }
        return ['error' => null, '_view' => 'login'];
    }

    /**
     * handle post login
     * @param Request $request
     * @return null|array{_view: string, error: ?string}
     */
    public function index_post(Request $request)
    {
        $ctrl = $this->getController();
        $ctrl->checkUser(false);
        if ($this->getUser()) {
            $this->_redirect($ctrl::uri('@/'));
            return;
        }
        $redirect = $request->get('redirect') ?? $ctrl::uri('@/');

        $login = $request->get('login') ?? '';
        $password = $request->get('password') ?? '';
        $secret = $request->get('secret') ?? '';

        if (($secret !== '') && ($secret != '-')) {
            if (!$this->authenticateWithCode($login, $secret, $error)) {
                return ['_view' => 'login', 'error' => $error ?? __('Invalid code'), 'step' => 'secret', 'login' => $login];
            }
            $this->_redirect($redirect);
            return;
        }

        if (!$login || !$password) {
            return ['_view' => 'login', 'error' => __('Please enter login and password'), 'login' => $login];
        }

        $error = null;
        if (!$this->authenticate($login, $password, $error)) {
            return ['_view' => 'login', 'error' => $error ?? __('Invalid credentials'), 'step' => 'password', 'login' => $login];
        }
        $user = $this->getUser();

        if ($user && $user->auth_2fa_key && igk_app()->session->fjd_2fa_verified_for !== $user->clGuid) {
            return ['_view' => 'login/2fa', 'error' => null, 'redirect' => $redirect];
        }

        $this->_redirect($redirect);
    }

    /**
     * redirect to
     * @param string $c
     * @return void
     */
    private function _redirect(string $c)
    {
        igk_navto($c);
    }

    /**
     * step-1 identifier lookup: does this login require a 2FA code instead of a password.
     * only ever returns `requires2fa` (never whether the login exists) so an unknown login and
     * a known-but-non-2FA login look identical to the caller.
     *
     * When the login has WebAuthn credentials, this always issues a single real server
     * challenge covering every registered credential id (rather than delegating to the
     * WebAuthn module's FILTER_AUTH_TYPE hook, which only stashes a session challenge for the
     * single-credential case and leaves multi-credential accounts with no real challenge) —
     * webauth_authenticate_post below verifies the assertion against that same challenge.
     * @param Request $request
     * @return void
     */
    public function exists_post(Request $request)
    {
        igk_require_module('igk.authentications.WebAuthn');

        $login = trim((string)$request->get('login'));
        $user = igk_get_user_bylogin($login);
        $accepts = [];
        $data = (object)compact('login');
        if ($stored = WebAuthnDbUtility::AuthnFromFromUser($user)) {
            $ids = [];
            foreach ($stored as $row) {
                $seri = WebAuthnDbUtility::UnserialData($row->data);
                if ($seri && isset($seri->credentialId)) {
                    $ids[] = $seri->credentialId;
                }
            }
            if ($ids) {
                $accepts[] = 'webauthn';
                $webauth = new WebAuthn(igk_configs()->website_title, igk_sys_domain_name());
                $data->credentials = $webauth->getGetArgs($ids, 2000, true, true, true, true, true, true);
                igk_app()->session->webauthn_authenication_challenge = $webauth->getChallenge();
            }
        }
        if (TwoFactorAuth::IsEnabled($user)) {
            $accepts[] = '2fa';
        }
        igk_do_response(igk_json($user ? [
                'login' => $user->clLogin,
                'found' => true,
                'display' => $user->display(),
                'identifierType' => $accepts,
                'data' => (array)json_decode(json_encode($data))
            ] :
            ['error' => 'missing or user not found']
        ));
    }

    /**
     * verify a browser-produced WebAuthn assertion (navigator.credentials.get() result) against
     * the credential stored for $login and, on success, log the user in — the counterpart to
     * exists_post above, which stashed the challenge this checks against in
     * igk_app()->session->webauthn_authenication_challenge.
     * @param Request $request
     * @return void
     */
    public function webauth_authenticate_post(Request $request)
    {
        igk_require_module('igk.authentications.WebAuthn');

        $data = json_decode($request->getUploadedData());
        if (!$data || empty($data->credentials)) {
            igk_json(['error' => true, 'msg' => 'missing data'], RequestResponseCode::BadRequest);
        }

        $credentials = (object)$data->credentials;
        $login = trim((string)($data->login ?? ''));
        $user = $login !== '' ? igk_get_user_bylogin($login) : null;
        $rauth = $user ? WebAuthnDbUtility::AuthnDetectFromFromUser($user, $credentials->id) : null;

        if (!$user || !$rauth) {
            igk_json(['error' => true, 'msg' => 'missing user'], RequestResponseCode::Forbiden);
        }

        $cdata = WebAuthnDbUtility::UnserialData($rauth->data);
        if (!$cdata) {
            igk_json(['error' => true, 'msg' => 'missing credential data']);
        }

        $session = igk_app()->session;
        $challenge = $session->webauthn_authenication_challenge;
        if (empty($challenge)) {
            igk_json(['error' => true, 'msg' => 'missing challenge']);
        }

        $webauth = new WebAuthn(igk_configs()->website_title, igk_sys_domain_name());
        if ($webauth->processGet(
            base64_decode(igk_getv($credentials->response, 'clientDataJSON')),
            base64_decode(igk_getv($credentials->response, 'authenticatorData')),
            base64_decode(igk_getv($credentials->response, 'signature')),
            $cdata->credentialPublicKey,
            $challenge,
            null,
            true,
            true
        )) {
            $session->webauthn_authenication_challenge = null;
            igk_hook(IGKEvents::HOOK_USER_AUTHENTICATE, ['type' => 'webauthn', 'id' => $credentials->id]);
            if (!$this->getController()->login($user, null, false)) {
                igk_json(['error' => true, 'msg' => 'authentication failed']);
            }
            igk_json(['error' => false, 'msg' => 'successfully connected']);
        }

        igk_json(['error' => true, 'msg' => 'request was unsuccessful']);
    }

    /**
     * verify the 2FA code for the user authenticated in the previous step
     * @param Request $request
     * @return null|array{_view: string, error: ?string, redirect: string}
     */
    public function login2fa_post(Request $request)
    {
        $ctrl = $this->getController();
        $user = $this->getUser();
        $redirect = $request->get('redirect') ?? $ctrl::uri('@/');

        if (!$user || !$user->auth_2fa_key) {
            igk_navto($ctrl::uri('@/login'));
            return;
        }

        $code = (string)$request->get('code');
        if (!TwoFactorAuth::Verify($user->auth_2fa_key, $code)) {
            return ['_view' => 'login/2fa', 'error' => __('Invalid code. Please try again.'), 'redirect' => $redirect];
        }

        igk_app()->session->fjd_2fa_verified_for = $user->clGuid;
        igk_navto($redirect);
    }

    /**
     *
     * @param string $login
     * @param string $password
     * @param mixed &$error
     * @return bool
     */
    private function authenticate(string $login, string $password, &$error): bool
    {
        $ctrl = $this->getController();
        try {
            if ($ctrl->login($login, $password, false)) {
                return true;
            }
            $error = __('Invalid login or password');
            return false;
        } catch (\Exception $e) {
            $error = __('Authentication failed: {0}', $e->getMessage());
            return false;
        }
    }

    /**
     * passwordless login for 2FA-enabled accounts: the TOTP code is the sole credential —
     * reuses the framework's own login() by passing it the resolved Users instance with a null
     * password, which skips the password check entirely and just hydrates the session from
     * that user.
     * @param string $login
     * @param string $code
     * @param mixed &$error
     * @return bool
     */
    private function authenticateWithCode(string $login, string $code, &$error): bool
    {
        $user = $login !== '' ? igk_get_user_bylogin($login) : null;
        if (!$user || !TwoFactorAuth::IsEnabled($user)) {
            $error = __('Invalid login or code');
            return false;
        }
        if (!TwoFactorAuth::Verify($user->auth_2fa_key, $code)) {
            $error = __('Invalid code. Please try again.');
            return false;
        }
        if (!$this->getController()->login($user, null, false)) {
            $error = __('Authentication failed');
            return false;
        }
        igk_app()->session->fjd_2fa_verified_for = $user->clGuid;
        return true;
    }
}
