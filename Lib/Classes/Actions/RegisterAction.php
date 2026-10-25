<?php
// @author: C.A.D. BONDJE DOUE
// @file: RegisterAction.php
// @desc: account registration — creates an inactive account and mails a 24h activation link
namespace com\igkdev\projects\ForemJobDashboard\Actions;

use com\igkdev\projects\ForemJobDashboard\Services\RegistrationService;
use IGK\Actions\ActionBase;
use IGK\System\Http\Request;

/**
 * register action. Activation (@/register/activate?t=) is handled by Views/register/activate.phtml.
 * @package com\igkdev\projects\ForemJobDashboard\Actions
 */
class RegisterAction extends ActionBase
{
    public function index()
    {
        if ($this->getUser()) {
            igk_navto($this->getController()::uri('@/'));
            return;
        }
        return ['_view' => 'register', 'error' => null, 'sent' => false];
    }

    /**
     * @param Request $request
     * @return null|array{_view: string, error: ?string, sent: bool}
     */
    public function index_post(Request $request)
    {
        $ctrl = $this->getController();
        if ($this->getUser()) {
            igk_navto($ctrl::uri('@/'));
            return;
        }
        $email = (string)$request->get('email');
        $login = (string)$request->get('login');
        $r = RegistrationService::Register(
            $ctrl,
            $email,
            $login,
            (string)$request->get('password'),
            (string)$request->get('confirm'),
            self::ActivationUri($ctrl)
        );
        if ($r === true) {
            return ['_view' => 'register', 'error' => null, 'sent' => true, 'email' => $email];
        }
        return ['_view' => 'register', 'error' => self::ErrorMessage($r), 'sent' => false, 'email' => $email, 'login' => $login];
    }
    /**
     * absolute activation url (without the token), used in the mail
     */
    public static function ActivationUri($ctrl): string
    {
        return $ctrl::uri('@/register/activate'); // full uri by default
    }
    public static function ErrorMessage(string $code): string
    {
        switch ($code) {
            case RegistrationService::ERR_EMAIL:
                return __('Please enter a valid email address');
            case RegistrationService::ERR_LOGIN:
                return __('The login must have 3 to 60 characters (letters, digits, . _ - @)');
            case RegistrationService::ERR_PASSWORD:
                return sprintf(__('The password must have at least %d characters'), RegistrationService::MIN_PASSWORD);
            case RegistrationService::ERR_CONFIRM:
                return __('The password confirmation does not match');
            case RegistrationService::ERR_EXISTS:
                return __('This login or email is already used');
            case RegistrationService::ERR_MAIL:
                return __('The confirmation email could not be sent, please try again later');
        }
        return __('Registration failed, please try again');
    }
}
