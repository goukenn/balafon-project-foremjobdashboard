<?php
// @author: C.A.D. BONDJE DOUE
// @file: TwoFactorAuth.php
// @desc: dependency-free TOTP (RFC 6238, HMAC-SHA1, 30s step, 6 digits) helper.
//        Ported from the AssimilTraining project's TwoFactorAuth class. Relies on the
//        `auth_2fa_key` column on the shared users table, provided by the
//        igk/authentications/googleAuth2FA module (declared in balafon.config.json), and
//        renders the enrollment QR code via the core's igk/QrCode module.
// @date: 20260825 00:00:00
namespace com\igkdev\projects\ForemJobDashboard\Helpers;

use IGK\Models\Users;
use igk\QrCode\QrGenerator;

/**
 * @package com\igkdev\projects\ForemJobDashboard\Helpers
 * @author C.A.D. BONDJE DOUE
 */
class TwoFactorAuth
{
    const PERIOD = 30;
    const DIGITS = 6;
    const ISSUER = 'ForemJob Dashboard';
    const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     *
     * @param Users $user
     * @return bool
     */
    public static function IsEnabled(Users $user): bool
    {
        $s = $user->auth_2fa_key;
        return !empty($s);
    }

    public static function GenerateSecret(int $length = 20): string
    {
        return self::_base32Encode(random_bytes($length));
    }

    public static function GetOtpAuthUri(Users $user, string $secret): string
    {
        $label = rawurlencode(self::ISSUER . ':' . $user->clLogin);
        $issuer = rawurlencode(self::ISSUER);
        return "otpauth://totp/{$label}?secret={$secret}&issuer={$issuer}&period=" . self::PERIOD . "&digits=" . self::DIGITS;
    }

    /**
     * render the otpauth:// URI as a QR code, returned as a data: URI ready for an <img src>.
     * returns null if the igk/QrCode module can't be loaded (enrollment still works via the
     * plain-text secret/URI shown alongside it).
     * @param string $otpAuthUri
     * @return null|string
     */
    public static function BuildQrImageDataUri(string $otpAuthUri): ?string
    {
        try {
            igk_require_module('igk/QrCode');
            if (!class_exists(QrGenerator::class)) {
                return null;
            }
            $qr = new QrGenerator();
            $qr->type = QrGenerator::TYPE_SVG;
            return $qr->generateQr($otpAuthUri, 220, 8) ?: null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * verify a 6-digit code against a secret, tolerating ±1 time-step of clock drift
     * @param string $secret
     * @param string $code
     * @return bool
     */
    public static function Verify(string $secret, string $code): bool
    {
        $code = trim($code);
        if ($code === '' || !ctype_digit($code) || !$secret) {
            return false;
        }
        $timestep = (int)floor(time() / self::PERIOD);
        for ($i = -1; $i <= 1; $i++) {
            if (hash_equals(self::_generateCode($secret, $timestep + $i), $code)) {
                return true;
            }
        }
        return false;
    }

    private static function _generateCode(string $secret, int $timestep): string
    {
        $key = self::_base32Decode($secret);
        $time = pack('N*', 0) . pack('N*', $timestep);
        $hash = hash_hmac('sha1', $time, $key, true);
        $offset = ord(substr($hash, -1)) & 0x0F;
        $part = substr($hash, $offset, 4);
        $value = unpack('N', $part)[1] & 0x7FFFFFFF;
        $code = $value % (10 ** self::DIGITS);
        return str_pad((string)$code, self::DIGITS, '0', STR_PAD_LEFT);
    }

    private static function _base32Encode(string $data): string
    {
        $bits = '';
        foreach (str_split($data) as $char) {
            $bits .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }
        $output = '';
        foreach (str_split($bits, 5) as $chunk) {
            $chunk = str_pad($chunk, 5, '0');
            $output .= self::ALPHABET[bindec($chunk)];
        }
        return $output;
    }

    private static function _base32Decode(string $data): string
    {
        $data = strtoupper(rtrim($data, '='));
        $bits = '';
        foreach (str_split($data) as $char) {
            $pos = strpos(self::ALPHABET, $char);
            if ($pos === false) {
                continue;
            }
            $bits .= str_pad(decbin($pos), 5, '0', STR_PAD_LEFT);
        }
        $bytes = '';
        foreach (str_split($bits, 8) as $byte) {
            if (strlen($byte) < 8) {
                continue;
            }
            $bytes .= chr(bindec($byte));
        }
        return $bytes;
    }
}
