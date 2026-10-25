<?php
// @author: C.A.D. BONDJE DOUE
// @file: RegistrationService.php
// @desc: account registration: validation, inactive user creation, activation token (24h) and mail
namespace com\igkdev\projects\ForemJobDashboard\Services;

use com\igkdev\projects\ForemJobDashboard\Models\JobRegistrations;
use IGK\Models\Users;

class RegistrationService
{
    const TOKEN_TTL = 86400; // activation link validity: one day
    const MIN_PASSWORD = 8;

    const ERR_EMAIL = 'email';
    const ERR_LOGIN = 'login';
    const ERR_PASSWORD = 'password';
    const ERR_CONFIRM = 'confirm';
    const ERR_EXISTS = 'exists';
    const ERR_SAVE = 'save';
    const ERR_MAIL = 'mail';
    const ERR_TOKEN = 'token';
    const ERR_EXPIRED = 'expired';

    public static function ValidateEmail(string $email): bool
    {
        return strlen($email) <= 150 && filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    /**
     * an empty login is allowed (the email is then the login)
     */
    public static function ValidateLogin(string $login): bool
    {
        return $login === '' || (bool)preg_match('/^[A-Za-z0-9][A-Za-z0-9._@-]{2,59}$/', $login);
    }
    public static function ValidatePassword(string $password): bool
    {
        return strlen($password) >= self::MIN_PASSWORD;
    }
    /**
     * @return string the raw token (sent by mail, 48 hex chars)
     */
    public static function NewToken(): string
    {
        return bin2hex(random_bytes(24));
    }
    /**
     * only the hash is stored, a database leak does not give working links
     */
    public static function HashToken(string $token): string
    {
        return hash('sha256', $token);
    }
    public static function IsExpired(string $expires_at, ?int $now = null): bool
    {
        $t = strtotime($expires_at);
        return $t === false || $t < ($now ?? time());
    }
    public static function ExpiresAt(?int $now = null): string
    {
        return date('Y-m-d H:i:s', ($now ?? time()) + self::TOKEN_TTL);
    }
    /**
     * @param callable|null $mailer fn(string $to, string $subject, string $html): bool, defaults to the framework mailer
     * @return true|string true when the activation mail left, an ERR_* code otherwise
     */
    public static function Register($ctrl, string $email, string $login, string $password, string $confirm, string $activationBase, ?callable $mailer = null)
    {
        $email = trim($email);
        $login = trim($login);
        if (!self::ValidateEmail($email)) {
            return self::ERR_EMAIL;
        }
        if (!self::ValidateLogin($login)) {
            return self::ERR_LOGIN;
        }
        if (!self::ValidatePassword($password)) {
            return self::ERR_PASSWORD;
        }
        if ($password !== $confirm) {
            return self::ERR_CONFIRM;
        }
        $login = $login ?: $email;
        if (strlen($login) > 60) {
            return self::ERR_LOGIN;
        }
        // a pending (inactive) account is simply re-issued a new link
        $pending = null;
        if ($u = Users::select_row([Users::FD_CL_LOGIN => $login])) {
            $reg = JobRegistrations::select_row([JobRegistrations::FD_USER_GUID => $u->clGuid]);
            if ($u->clStatus != -1 || !$reg || strcasecmp($reg->{JobRegistrations::FD_EMAIL}, $email) !== 0) {
                return self::ERR_EXISTS;
            }
            $pending = $u;
        } elseif (JobRegistrations::select_row([JobRegistrations::FD_EMAIL => $email])) {
            return self::ERR_EXISTS; // email already used by an account with another login
        }
        if (!$pending) {
            $pending = Users::create([
                Users::FD_CL_LOGIN => $login,
                Users::FD_CL_PWD => $password, // hashed by the column insert function
                Users::FD_CL_GUID => igk_create_guid(),
                Users::FD_CL_STATUS => -1,
                Users::FD_CL_CLASS_NAME => get_class($ctrl),
            ]);
            if (!$pending) {
                return self::ERR_SAVE;
            }
        }
        return self::IssueToken($pending->clGuid, $email, $activationBase, $mailer);
    }
    /**
     * the SMTP provider drops mail whose sender differs from the authenticated account (mail_user),
     * so use it when it is an address, else the framework no-reply address
     */
    public static function SenderAddress(): string
    {
        $user = (string)igk_configs()->get('mail_user');
        return self::ValidateEmail($user) ? $user : igk_mail_noreply_address();
    }
    /**
     * new link for a pending account (also used by "resend")
     * @return true|string
     */
    public static function IssueToken(string $guid, string $email, string $activationBase, ?callable $mailer = null)
    {
        $token = self::NewToken();
        $data = [
            'token' => self::HashToken($token),
            'expires_at' => self::ExpiresAt(),
            'used_at' => null,
            'email' => $email,
        ];
        if ($reg = JobRegistrations::select_row([JobRegistrations::FD_USER_GUID => $guid])) {
            foreach ($data as $k => $v) {
                $reg->{'jrg_' . $k} = $v;
            }
            $reg->save();
        } else {
            JobRegistrations::insert(['user_guid' => $guid] + $data);
        }
        $mailer = $mailer ?? function ($to, $subject, $html) {
            return igk_mail_sendmail($to, self::SenderAddress(), $subject, $html);
        };
        $link = $activationBase . (strpos($activationBase, '?') === false ? '?' : '&') . 't=' . $token;
        $html = '<p>' . htmlspecialchars(__('Welcome! Confirm your registration by opening this link:')) . '</p>'
            . '<p><a href="' . htmlspecialchars($link) . '">' . htmlspecialchars($link) . '</a></p>'
            . '<p>' . htmlspecialchars(__('This link is valid for 24 hours.')) . '</p>';
        return $mailer($email, __('Confirm your registration'), $html) ? true : self::ERR_MAIL;
    }
    /**
     * @return Users|string the activated user, or ERR_TOKEN / ERR_EXPIRED
     */
    public static function Activate(string $token)
    {
        if (!preg_match('/^[a-f0-9]{48}$/', $token)) {
            return self::ERR_TOKEN;
        }
        $reg = JobRegistrations::select_row([JobRegistrations::FD_TOKEN => self::HashToken($token)]);
        if (!$reg || $reg->{JobRegistrations::FD_USED_AT}) {
            return self::ERR_TOKEN;
        }
        if (self::IsExpired($reg->{JobRegistrations::FD_EXPIRES_AT})) {
            return self::ERR_EXPIRED;
        }
        $user = Users::select_row([Users::FD_CL_GUID => $reg->{JobRegistrations::FD_USER_GUID}]);
        if (!$user) {
            return self::ERR_TOKEN;
        }
        $user->activate();
        $reg->{JobRegistrations::FD_USED_AT} = date('Y-m-d H:i:s');
        $reg->save();
        return $user;
    }
    /**
     * "resend" after an expired link: only for a still inactive account, same answer either way
     */
    public static function Resend(string $email, string $activationBase, ?callable $mailer = null): void
    {
        $reg = JobRegistrations::select_row([JobRegistrations::FD_EMAIL => trim($email)]);
        $user = $reg ? Users::select_row([Users::FD_CL_GUID => $reg->{JobRegistrations::FD_USER_GUID}]) : null;
        if ($user && $user->clStatus == -1) {
            self::IssueToken($user->clGuid, $reg->{JobRegistrations::FD_EMAIL}, $activationBase, $mailer);
        }
    }
}
