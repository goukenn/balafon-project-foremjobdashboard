<?php
// @author: C.A.D. BONDJE DOUE
// @file: KboServiceTest.php
namespace com\igkdev\projects\ForemJobDashboard\Tests;

use com\igkdev\projects\ForemJobDashboard\Helpers\JobUtility;
use com\igkdev\projects\ForemJobDashboard\Services\KboService;
use IGK\Tests\BaseTestCase;

/**
 * KBO number normalization / page parsing (offline, saved fixture) and follow-up date default
 * @package com\igkdev\projects\ForemJobDashboard\Tests
 */
class KboServiceTest extends BaseTestCase
{
    public function test_normalize()
    {
        $this->assertEquals('0403199702', KboService::Normalize('BE 0403.199.702'));
        $this->assertEquals('0403199702', KboService::Normalize('403199702'));
        $this->assertNull(KboService::Normalize('0403.199.703'), 'bad checksum');
        $this->assertNull(KboService::Normalize('abc'));
        $this->assertNull(KboService::Normalize(null));
    }
    public function test_parse_fixture()
    {
        $r = KboService::Parse(file_get_contents(__DIR__ . '/fixtures/kbo_0403199702.fr.html'));
        $this->assertEquals('0403.199.702', $r['number']);
        $this->assertEquals('BNP Paribas Fortis', $r['name']);
        $this->assertEquals('Actif', $r['status']);
        $this->assertEquals('1934-12-05', $r['start_date']);
        $this->assertEquals('Rue Montagne du Parc 3', $r['address']);
        $this->assertEquals('1000 Bruxelles', $r['locality']);
        $this->assertEquals('Société anonyme', $r['legal_form']);
        $this->assertNull($r['phone']);
    }
    public function test_parse_not_found()
    {
        $this->assertNull(KboService::Parse('<html><body><div id="table"></div>Paramètre incorrect</body></html>'));
    }
    public function test_default_follow_at()
    {
        $this->assertEquals('2026-10-28', JobUtility::DefaultFollowAt(null, '2026-10-21'));
        $this->assertEquals('2026-11-04', JobUtility::DefaultFollowAt('+2 weeks', '2026-10-21'));
        $this->assertEquals('2026-10-28', JobUtility::DefaultFollowAt('garbage', '2026-10-21'));
    }
}
