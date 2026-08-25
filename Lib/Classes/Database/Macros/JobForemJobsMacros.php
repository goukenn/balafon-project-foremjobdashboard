<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobForemJob.phtml
// @desc: macros for model JobForemJobs
// @date: 20251210 18:38:03

declare(strict_types=1);
namespace com\igkdev\projects\ForemJobDashboard\Database\Macros;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database\Macros
* @author C.A.D. BONDJE DOUE
*/
abstract class JobForemJobsMacros
{
    /**
     * echeck existance 
     * @param JobForemJobs $model 
     * @param string $refid 
     * @return bool 
     */
    public static function checkExists(JobForemJobs $model, string $refid):bool{
        return null === $model::GetCache(JobForemJobs::FD_REFERENCE, $refid);
    }
}