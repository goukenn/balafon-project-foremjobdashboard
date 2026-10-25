<?php
// @author: C.A.D. BONDJE DOUE
// @file: RegistrationServiceTest.php
namespace com\igkdev\projects\ForemJobDashboard\Tests;

use com\igkdev\projects\ForemJobDashboard\Services\RegistrationService as R;
use IGK\Tests\BaseTestCase;

/**
 * registration rules that need no database: validation, token format/hash, 24h expiry
 * @package com\igkdev\projects\ForemJobDashboard\Tests
 */
class RegistrationServiceTest extends BaseTestCase
{
    public function test_validate_email()
    {
        $this->assertTrue(R::ValidateEmail('a@b.co'));
        $this->assertFalse(R::ValidateEmail('nope'));
        $this->assertFalse(R::ValidateEmail(''));
    }
    public function test_validate_login_is_optional_but_constrained()
    {
        $this->assertTrue(R::ValidateLogin(''));
        $this->assertTrue(R::ValidateLogin('john.doe-1'));
        $this->assertFalse(R::ValidateLogin('ab'));
        $this->assertFalse(R::ValidateLogin('bad login'));
        $this->assertFalse(R::ValidateLogin(str_repeat('a', 61)));
    }
    public function test_validate_password()
    {
        $this->assertFalse(R::ValidatePassword('short'));
        $this->assertTrue(R::ValidatePassword('long-enough'));
    }
    public function test_token_format_and_hash()
    {
        $t = R::NewToken();
        $this->assertMatchesRegularExpression('/^[a-f0-9]{48}$/', $t);
        $this->assertNotEquals($t, R::NewToken());
        $this->assertEquals(64, strlen(R::HashToken($t)));
        $this->assertNotEquals($t, R::HashToken($t));
    }
    public function test_expiry_is_one_day()
    {
        $now = 1700000000;
        $exp = R::ExpiresAt($now);
        $this->assertEquals($now + 86400, strtotime($exp));
        $this->assertFalse(R::IsExpired($exp, strtotime($exp) - 1));
        $this->assertTrue(R::IsExpired($exp, strtotime($exp) + 1));
        $this->assertTrue(R::IsExpired('garbage'));
    }
}
