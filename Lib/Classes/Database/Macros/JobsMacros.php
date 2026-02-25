<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs.phtml
// @desc: macros for model Jobs
// @date: 20251113 08:03:33
namespace com\igkdev\projects\ForemJobDashboard\Database\Macros;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
/**
* macros for jobs operations
* @package com\igkdev\projects\ForemJobDashboard\Database\Macros
* @author C.A.D. BONDJE DOUE
*/
abstract class JobsMacros{
    /**
     * retrieve forem referenche
     * @param Jobs $model 
     * @return null|string 
     */
   public static function foremReference(Jobs $model): ?string{
    if ($c = JobForemJobs::GetCache(JobForemJobs::FD_JOB_ID, $model->id)) {
        return $c->{JobForemJobs::FD_REFERENCE};
    }
    return null;
   }
}