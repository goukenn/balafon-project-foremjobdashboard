<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobIdentifyTest.php
// @date: 20260914 12:12:14
namespace com\igkdev\projects\ForemJobDashboard\Tests;

use com\igkdev\projects\ForemJobDashboard\Helpers\JobUtility;
use com\igkdev\projects\ForemJobDashboard\ModelUtilities\MainTaskModelUtility;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use ForemJobDashboardController;
use IGK\Models\Users;
use IGK\Tests\BaseTestCase;

/**
* validates that a job entry's `identify` value is calculated when a new job is added
* @package com\igkdev\projects\ForemJobDashboard\Tests
* @author C.A.D. BONDJE DOUE
*/
class JobIdentifyTest extends BaseTestCase{
    /**
    * @var MainTaskModelUtility
    */
    private $main;
    /**
    * @var JobUsers
    */
    private $jobUser;
    /**
    * @var array id of every Jobs row created by a test, cleaned up in tearDown
    */
    private $createdJobIds = [];

    protected function setUp(): void{
        parent::setUp();
        $ctrl = ForemJobDashboardController::ctrl(true);
        $this->main = new MainTaskModelUtility($ctrl);
        // job_users.guid is a foreign key into the (test-DB) users table, so it must
        // reference a real Users row there; a dedicated throwaway JobUsers row is still
        // created/torn down per test to avoid depending on or colliding with any existing one.
        $user = Users::select_first();
        $this->jobUser = new JobUsers(["guid" => $user->clGuid]);
        $this->jobUser->insert($this->jobUser->to_array(), true, true);
        $this->createdJobIds = [];
    }

    protected function tearDown(): void{
        foreach ($this->createdJobIds as $jobId){
            Jobs::delete([Jobs::FD_ID => $jobId]);
        }
        $this->jobUser->delete();
        parent::tearDown();
    }

    private function addTestJob(string $title): Jobs{
        $job = $this->main->addJob($title, $this->jobUser);
        $this->createdJobIds[] = $job->{Jobs::FD_ID};
        return $job;
    }

    /**
    * computing the same title/company/reference twice yields the same identify hash
    */
    public function testCreateJobIdentifyIsDeterministic(){
        $a = JobUtility::CreateJobIdentify("Backend Developer", "Acme Corp", "REF-1");
        $b = JobUtility::CreateJobIdentify("Backend Developer", "Acme Corp", "REF-1");
        $this->assertEquals($a, $b);
        $this->assertNotEmpty($a);
    }

    /**
    * changing the title, company or reference individually changes the computed identify hash
    */
    public function testCreateJobIdentifyDiffersOnDifferentInputs(){
        $base = JobUtility::CreateJobIdentify("Backend Developer", "Acme Corp", "REF-1");
        $this->assertNotEquals($base, JobUtility::CreateJobIdentify("Frontend Developer", "Acme Corp", "REF-1"));
        $this->assertNotEquals($base, JobUtility::CreateJobIdentify("Backend Developer", "Other Corp", "REF-1"));
        $this->assertNotEquals($base, JobUtility::CreateJobIdentify("Backend Developer", "Acme Corp", "REF-2"));
    }

    /**
    * an absent reference (null) and an empty-string reference produce the same identify hash
    */
    public function testCreateJobIdentifyIgnoresEmptyReference(){
        $withNull = JobUtility::CreateJobIdentify("Backend Developer", "Acme Corp", null);
        $withEmpty = JobUtility::CreateJobIdentify("Backend Developer", "Acme Corp", "");
        $this->assertEquals($withNull, $withEmpty);
    }

    /**
    * adding a new job through MainTaskModelUtility::addJob() computes and persists its identify
    */
    public function testAddingNewJobComputesAndPersistsIdentify(){
        $title = "QA Engineer " . uniqid();
        $expected = JobUtility::CreateJobIdentify($title, '', null);

        $job = $this->addTestJob($title);
        $this->assertEquals($expected, $job->{Jobs::FD_IDENTIFY});

        $persisted = Jobs::select_row([Jobs::FD_ID => $job->{Jobs::FD_ID}]);
        $this->assertEquals($expected, $persisted->{Jobs::FD_IDENTIFY});
    }

    /**
    * identify is computed from title+company+reference (see JobUtility::CreateJobIdentify); addJob()
    * always passes an empty company and null reference, so for THIS call path two jobs with the same
    * title alone collide on the same identify hash. jbs_identify is a unique column, so the second
    * insert throws a raw mysqli_sql_exception instead of failing gracefully - addJob() has no
    * try/catch or pre-check around it.
    */
    public function testAddingJobWithSameTitleTwiceThrowsOnDuplicateIdentify(){
        $title = "Duplicate Title Job " . uniqid();
        $first = $this->addTestJob($title);
        $this->assertNotNull($first);

        $this->expectException(\mysqli_sql_exception::class);
        $this->main->addJob($title, $this->jobUser);
    }
}
