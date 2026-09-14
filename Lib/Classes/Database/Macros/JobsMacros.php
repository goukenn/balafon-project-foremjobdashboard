<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs.phtml
// @desc: macros for model Jobs
// @date: 20251113 08:03:33
namespace com\igkdev\projects\ForemJobDashboard\Database\Macros;

use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobForemJobs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Database\DataAdapterBase;
use IGK\Helper\StringUtility;

/**
 * macros for jobs operations
 * @package com\igkdev\projects\ForemJobDashboard\Database\Macros
 * @author C.A.D. BONDJE DOUE
 */
abstract class JobsMacros
{
    /**
     * retrieve forem referenche
     * @param Jobs $model 
     * @return null|string 
     */
    public static function foremReference(Jobs $model): ?string
    {
        if ($c = JobForemJobs::GetCache(JobForemJobs::FD_JOB_ID, $model->id)) {
            return $c->{JobForemJobs::FD_REFERENCE};
        }
        return null;
    }
    /**
     * attach forem reference
     * @param Jobs $model 
     * @param mixed $ref_id 
     * @return null|bool|DataAdapterBase 
     */
    public static function attachForemReference(Jobs $model, $ref_id)
    {
        return JobForemJobs::insertIfNotExists([
            JobForemJobs::FD_JOB_ID => $model->id,
            JobForemJobs::FD_REFERENCE => $ref_id
        ]);
    }

    /**
     * macros helper to remove all detected duplicates
     * @param Jobs $model 
     * @param mixed $rows 
     * @param mixed $owner 
     * @return void 
     */
    public static function clearDuplicates(Jobs $model, $rows, $owner = null)
    {
        foreach ($rows as $row) {
            $id = $row->{Jobs::FD_ID};
            if ($owner) {
                $owner_id = $owner->{Jobs::FD_ID};
                JobDocs::update([
                    JobDocs::FD_JOB_ID => $owner_id
                ], [
                    JobDocs::FD_JOB_ID => $id
                ]);
                JobForemJobs::update(
                    [
                        JobForemJobs::FD_JOB_ID => $owner_id
                    ],
                    [JobForemJobs::FD_JOB_ID => $id]
                );
            } else {
                JobForemJobs::delete(
                    [JobForemJobs::FD_JOB_ID => $id]
                );
                JobDocs::delete([
                    JobDocs::FD_JOB_ID => $id
                ]);
            }
            Jobs::delete([Jobs::FN_ID() => $row->{Jobs::FD_ID}]);
        }
    }

    
     public static function findDuplicateGroups(Jobs $model, int $userId): array
    {
        $cond = ['jbs_user_id' => $userId];
        $rows = Jobs::prepare()
            ->with(JobEnterprises::table(), 'enterprise')
            ->join_left(JobEnterprises::table(), sprintf('%s=%s', JobEnterprises::FN_ID(), Jobs::FD_ENTERPRISE_ID))
            ->conditions($cond)
            // ->limit(0,100)
            ->execute()->to_array();
        $groups = [];
        foreach ($rows as $row) {
            $key = StringUtility::Slugify($row->{Jobs::FD_TITLE}) . '|' . ($row->{Jobs::FD_ENTERPRISE_ID} ?: '0');
            $groups[$key][] = $row;
        }
        return array_filter($groups, function ($g) {
            return count($g) > 1;
        });
    }
}
