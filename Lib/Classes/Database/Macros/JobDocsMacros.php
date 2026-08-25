<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobDocs.phtml
// @desc: macros for model JobDocs
// @date: 20251211 17:36:21
namespace com\igkdev\projects\ForemJobDashboard\Database\Macros;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\JobDocTypes as EnumJobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use IGK\Models\ModelBase;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database\Macros
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database\Macros
*/
abstract class JobDocsMacros
{
    /**
     * retrive type name from model
     * @param JobDocs $model 
     * @return string 
     */
    public static function typeName(JobDocs $model): string
    {
        return JobDocTypes::GetCache(JobDocTypes::FD_ID, $model->job_doc_type_id)->name ?? 'unknown';
    }
    /**
    * auto generate doc.
    * @param JobDocs $model
    * @param mixed $user
    * @return bool
    */
    public static function isUserFileDocument(JobDocs $model, $user): bool
    {
        $t = EnumJobDocTypes::FILE();
        $r = json_decode($model->value);
        if ($r->type != 'template') {
            $path = igk_getv($r, 'path');
            if ($path && $model->isOwnedBy($user)) {
                return true;
            }
        }
        return false;
    }
    /**
    * auto generate doc.
    * @param JobDocs $model
    * @param mixed $user
    * @return bool
    */
    public static function isOwnedBy(JobDocs $model, $user): bool {
        $q = Jobs::GetCache(Jobs::FD_ID, $model->job_doc_type_id);
        $u = JobUsers::GetCache(JobUsers::FD_GUID, $user->clGuid);
        return $q->user_id == $u->id;;
    }
}