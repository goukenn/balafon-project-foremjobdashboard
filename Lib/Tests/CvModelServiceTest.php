<?php
// @author: C.A.D. BONDJE DOUE
// @file: CvModelServiceTest.php
namespace com\igkdev\projects\ForemJobDashboard\Tests;

use com\igkdev\projects\ForemJobDashboard\Models\JobCvModels;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use com\igkdev\projects\ForemJobDashboard\Services\CvModelService;
use IGK\Models\Users;
use IGK\Tests\BaseTestCase;

/**
 * saved cv models: html cleaning, per-user limit, duplicate names, default model
 * @package com\igkdev\projects\ForemJobDashboard\Tests
 */
class CvModelServiceTest extends BaseTestCase
{
    private $jobUser;
    private $uid;

    protected function setUp(): void
    {
        parent::setUp();
        \ForemJobDashboardController::ctrl(true);
        try {
            CvModelService::All(0);
        } catch (\Throwable $e) {
            $this->markTestSkipped('job_cv_models table missing in the test database (migrate it first)');
        }
        $user = Users::select_first();
        $this->jobUser = new JobUsers(["guid" => $user->clGuid]);
        $this->jobUser->insert($this->jobUser->to_array(), true, true);
        $this->uid = (int)$this->jobUser->{JobUsers::FD_ID};
    }
    protected function tearDown(): void
    {
        JobCvModels::delete([JobCvModels::FD_USER_ID => $this->uid]);
        $this->jobUser->delete();
        parent::tearDown();
    }
    public function test_sanitize()
    {
        $r = CvModelService::Sanitize('<div onclick=x>a <b style="x">b</b></div><script>alert(1)</script><a href="javascript:x">l</a> %__firstName__%');
        $this->assertEquals('<p>a <b>b</b></p><a>l</a> %__firstName__%', $r);
    }
    public function test_limit_duplicate_and_default()
    {
        $first = CvModelService::Save($this->uid, null, 'One', '<p>1</p>');
        $this->assertInstanceOf(JobCvModels::class, $first);
        $this->assertEquals(1, $first->{JobCvModels::FD_IS_DEFAULT}, 'first model is the default');
        $this->assertEquals(CvModelService::ERR_DUPLICATE, CvModelService::Save($this->uid, null, ' one ', 'x'));
        $this->assertEquals(CvModelService::ERR_NAME, CvModelService::Save($this->uid, null, '  ', 'x'));
        for ($i = 2; $i <= CvModelService::MAX_MODELS; $i++) {
            $this->assertInstanceOf(JobCvModels::class, CvModelService::Save($this->uid, null, "Model $i", '<p>x</p>'));
        }
        $this->assertEquals(CvModelService::ERR_LIMIT, CvModelService::Save($this->uid, null, 'Too many', 'x'));
        // updating an existing one is still allowed at the limit
        $up = CvModelService::Save($this->uid, (int)$first->{JobCvModels::FD_ID}, 'One bis', '<p>2</p>');
        $this->assertInstanceOf(JobCvModels::class, $up);
        $this->assertCount(CvModelService::MAX_MODELS, CvModelService::All($this->uid));
        // deleting the default promotes another model
        $this->assertTrue(CvModelService::Delete($this->uid, (int)$first->{JobCvModels::FD_ID}));
        $all = CvModelService::All($this->uid);
        $this->assertEquals(1, $all[0]->{JobCvModels::FD_IS_DEFAULT});
        // another user cannot read it
        $this->assertNull(CvModelService::Get($this->uid + 100000, (int)$all[0]->{JobCvModels::FD_ID}));
    }
}
