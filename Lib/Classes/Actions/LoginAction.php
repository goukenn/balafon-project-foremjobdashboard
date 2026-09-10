<?php
// @author: C.A.D. BONDJE DOUE
// @file: LoginAction.php
// @desc: login action — 
// @date: 20260825 00:00:00
namespace com\igkdev\projects\ForemJobDashboard\Actions;

use com\igkdev\projects\ForemJobDashboard\Helpers\TwoFactorAuth;
use IGK\Actions\ActionBase;
use IGK\Actions\Traits\AuthenticatorWith2faActionTrait;
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
    use AuthenticatorWith2faActionTrait;

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

}
