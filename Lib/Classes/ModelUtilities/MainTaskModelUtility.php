<?php
// @author: C.A.D. BONDJE DOUE
// @file: MainTaskModelUtility.php
// @desc: module utility MainTaskModelUtility
// @date: 20240904 20:10:49
namespace com\igkdev\projects\ForemJobDashboard\ModelUtilities;

use com\igkdev\projects\ForemJobDashboard\Models\ForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use IGK\Database\DataAdapterBase;
use IGK\Models\Users;
use IGKDbUtility;

///<summary>view entry point</summary>
/**
* view entry point
* @package com\igkdev\projects\ForemJobDashboard\ModelUtilities
* @author C.A.D. BONDJE DOUE
*/
class MainTaskModelUtility extends IGKDbUtility{
    /**
     * register user
     * @param Users $user 
     * @return ?JobUsers
     */
    public function registerUser(Users $user){
        $ru = JobUsers::insertIfNotExists([
            JobUsers::FD_GUID=>$user->clGuid
        ]);
        if($ru === true){
            $ru = JobUsers::last();
        }
        return $ru;
    }
    /**
     * 
     * @return null|JobUsers 
     */
    public function last(){
        return JobUsers::Get("id", JobUsers::last_id());
    }
    /**
     * get is system users is registrated user 
     * @param Users $user 
     * @return bool 
     */
    public function isRegisterUser(Users $user){
        return JobUSers::select_row([
            JobUsers::FD_GUID=>$user->clGuid
        ]) != null;
    }
    public function addJob(string $title, JobUsers $user, ?int $timespan=null){
        $date = !is_null($timespan) || ($timespan>0)? date('Y-m-d', $timespan) : JobUsers::FC_NOW;
        $l = Jobs::insert([
            'guid' => igk_create_guid(),
           'title' => $title,
           'from' => 0,
           'type' => 0,
           'status' => 0,
           'user_id' => $user->id,
           'description' => null,
           'summary' => null,
           'path' => '',
           'Create_At' => $date,
           'Update_At' => $date
        ]);
        return $l;
    }
    public function isForemJobs(Jobs $job):bool{
        $m = JobForemJobs::Get(JobForemJobs::FD_JOB_ID, $job->{Jobs::FD_ID});
        if ($m){
            return true;
        }
        return false;
    }

    /**
     * add a job to forem reference
     * @param Jobs $job 
     * @param string $reference 
     * @return null|bool|DataAdapterBase 
     */
    public function registerForemJob(Jobs $job , string $reference) {
        $cond = [JobForemJobs::FD_JOB_ID=>$job->{Jobs::FD_ID}];
        return JobForemJobs::insertIfNotExists($cond, array_merge($cond, [
            JobForemJobs::FD_REFERENCE=>$reference
        ]));
    }
}