<?php
// @author: C.A.D. BONDJE DOUE
// @file: CalendarServiceTest.php
namespace com\igkdev\projects\ForemJobDashboard\Tests;

use com\igkdev\projects\ForemJobDashboard\Services\CalendarService;
use com\igkdev\projects\ForemJobDashboard\Models\JobAppointments;
use com\igkdev\projects\ForemJobDashboard\Models\JobCalendarFeeds;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use IGK\Models\Users;
use IGK\Tests\BaseTestCase;

/**
 * calendar helpers that need no database: date parsing and ICS text rules (RFC 5545)
 * @package com\igkdev\projects\ForemJobDashboard\Tests
 */
class CalendarServiceTest extends BaseTestCase
{
    public function test_parse_date()
    {
        $this->assertEquals('2026-10-23 14:30:00', CalendarService::ParseDate('2026-10-23T14:30'));
        $this->assertEquals('2026-10-23 00:00:00', CalendarService::ParseDate('2026-10-23'));
        $this->assertNull(CalendarService::ParseDate(''));
        $this->assertNull(CalendarService::ParseDate('tomorrow'));
    }
    public function test_ics_escape()
    {
        $this->assertEquals('a\\, b\; c\\\\d\\ne', CalendarService::IcsEscape("a, b; c\\d\ne"));
    }
    public function test_ics_fold_keeps_lines_short_and_utf8_whole()
    {
        $line = 'SUMMARY:' . str_repeat('é', 120);
        $folded = CalendarService::IcsFold($line);
        foreach (explode("\r\n", $folded) as $l) {
            $this->assertLessThanOrEqual(75, strlen($l));
            $this->assertTrue(mb_check_encoding($l, 'UTF-8'));
        }
        $this->assertEquals($line, str_replace("\r\n ", '', $folded), 'unfolding restores the line');
    }

    /**
     * database round trip: needs the job_appointments tables (balafon --db:initdb ForemJobDashboardController)
     */
    public function test_save_due_ics_and_feed_token()
    {
        \ForemJobDashboardController::ctrl(true);
        try {
            CalendarService::All(0);
        } catch (\Throwable $e) {
            $this->markTestSkipped('job_appointments table missing in the test database: ' . $e->getMessage());
        }
        $user = Users::select_first();
        $ju = new JobUsers(["guid" => $user->clGuid]);
        $ju->insert($ju->to_array(), true, true);
        $uid = (int)$ju->{JobUsers::FD_ID};
        try {
            $this->assertEquals(CalendarService::ERR_TITLE, CalendarService::Save($uid, null, ['title' => ' ', 'start_at' => '2026-10-23T10:00']));
            $this->assertEquals(CalendarService::ERR_DATE, CalendarService::Save($uid, null, ['title' => 'x', 'start_at' => '2026-10-23T10:00', 'end_at' => '2026-10-23T09:00']));
            $this->assertEquals(CalendarService::ERR_EMAIL, CalendarService::Save($uid, null, ['title' => 'x', 'start_at' => '2026-10-23T10:00', 'contact_email' => 'nope']));
            $a = CalendarService::Save($uid, null, [
                'title' => 'Interview, ACME', 'kind' => 'interview', 'start_at' => '2026-10-23T10:00',
                'remind_at' => '2026-10-22T09:00', 'contact_email' => 'hr@acme.test', 'location' => 'Brussels',
            ]);
            $this->assertInstanceOf(JobAppointments::class, $a);
            $this->assertCount(1, CalendarService::Due($uid, '2026-10-22 10:00:00'));
            $this->assertCount(0, CalendarService::Due($uid, '2026-10-22 08:00:00'));
            $ics = CalendarService::BuildIcs(CalendarService::All($uid), 'Test');
            $this->assertStringContainsString("SUMMARY:Interview\\, ACME\r\n", $ics);
            $this->assertStringContainsString('TRIGGER:-PT1500M', $ics, 'alarm = start minus recall date');
            $this->assertStringStartsWith('mailto:hr%40acme.test', CalendarService::MailtoUrl($a));
            $this->assertTrue(CalendarService::SetStatus($uid, $a->{JobAppointments::FD_ID}, CalendarService::STATUS_DONE));
            $this->assertCount(0, CalendarService::Due($uid, '2026-10-22 10:00:00'), 'done is no longer due');
            $token = CalendarService::FeedToken($uid);
            $this->assertEquals($uid, CalendarService::UserIdByToken($token));
            $this->assertNotEquals($token, CalendarService::RegenerateToken($uid));
            $this->assertNull(CalendarService::UserIdByToken($token), 'old token is revoked');
        } finally {
            JobAppointments::delete([JobAppointments::FD_USER_ID => $uid]);
            JobCalendarFeeds::delete([JobCalendarFeeds::FD_USER_ID => $uid]);
            $ju->delete();
        }
    }
}
