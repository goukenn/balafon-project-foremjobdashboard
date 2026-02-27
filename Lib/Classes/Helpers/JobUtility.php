<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUtility.php
// @date: 20250414 06:47:14
namespace com\igkdev\projects\ForemJobDashboard\Helpers;
use com\igkdev\projects\ForemJobDashboard\JobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Helper\IO;
///<summary></summary>

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Helpers
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Helpers
*/
class JobUtility{

    /**
    * auto generate doc.
    * @param Jobs $job
    * @param mixed $src
    * @param bool $append
    */
    public static function StoreTemplateResponse(Jobs $job, $src, bool $append=false){
        $type = JobDocTypes::RESPONSE;
        $doctype_id = JobDocTypes::GetCacheData($type)->id;
        $r = [
            JobDocs::FD_JOB_ID => $job->id,
            JobDocs::FD_JOB_DOC_TYPE_ID =>  $doctype_id,
            JobDocs::FD_VALUE => json_encode((object)[
                'content' => $src,
                'type' => 'template',
                'size' => strlen($src)
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            )
        ];
        if ($append) {
            $s = JobDocs::insert($r);
        } else
            $s = JobDocs::createIfNotExists($r);
    }

    /**
    * auto generate doc.
    * @param Jobs $job
    * @param mixed $src
    * @param bool $append
    */
    public static function StoreResponse(Jobs $job, $src, bool $append){
        $offer_dir = $job->getController()->getOfferDir();
        $tfile = $offer_dir . $job->id;
        $type = JobDocTypes::RESPONSE;
        $doctype_id = JobDocTypes::GetCacheData($type)->id;
        $v_suffix = '';
        $r = [
            JobDocs::FD_JOB_ID => $job->id,
            JobDocs::FD_JOB_DOC_TYPE_ID =>  $doctype_id,
            JobDocs::FD_VALUE => json_encode((object)[
                'path' => '/' . $job->id . $v_suffix,
                'type' => 'plain/text',
                'size' => strlen($src)
            ])
        ];
        $s = null;
        if ($append) {
            $s = JobDocs::insert($r);
        } else
            $s = JobDocs::createIfNotExists($r);
        IO::CreateDir(
            dirname($tfile)
        );
        igk_io_w2file($tfile.$v_suffix, $src);
    }
}