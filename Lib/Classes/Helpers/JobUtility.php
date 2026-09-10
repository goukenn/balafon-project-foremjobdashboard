<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUtility.php
// @date: 20250414 06:47:14
namespace com\igkdev\projects\ForemJobDashboard\Helpers;
use com\igkdev\projects\ForemJobDashboard\JobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use ForemJobDashboardController;
use IGK\Helper\IO;
use IGK\Helper\StringUtility;
use IGK\System\Console\Logger;
use IGK\System\IO\Path;

/**
 * auto generate doc.
 * @package com\igkdev\projects\ForemJobDashboard\Helpers
 * @author C.A.D. BONDJE DOUE
 */
/**
 * auto generate doc.
 * @package com\igkdev\projects\ForemJobDashboard\Helpers
 */
class JobUtility
{
    /**
     * auto generate doc.
     * @param Jobs $job
     * @param mixed $src
     * @param bool $append
     */
    public static function StoreTemplateResponse(Jobs $job, $src, bool $append = false)
    {
        $type = JobDocTypes::RESPONSE;
        $doctype_id = JobDocTypes::GetCacheData($type)->id;
        $r = [
            JobDocs::FD_JOB_ID => $job->id,
            JobDocs::FD_JOB_DOC_TYPE_ID =>  $doctype_id,
            JobDocs::FD_VALUE => json_encode(
                (object)[
                    'content' => $src,
                    'type' => 'template',
                    'size' => strlen($src)
                ],
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
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
    public static function StoreResponse(Jobs $job, $src, bool $append)
    {
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
        igk_io_w2file($tfile . $v_suffix, $src);
    }
    /**
     * unlink unused files from local store 
     * @param ForemJobDashboardController $ctrl 
     * @return void 
     */
    public static function UnlinkUnusedFileFromLocalStorage(ForemJobDashboardController $ctrl)
    {
        $data = $ctrl->getDataDir();
        $path = Path::Combine($data, $ctrl::currentLoginPath());
        $ln = strlen($path) + 1;
        $cond = [];
        IO::GetFiles($path, function ($l) use ($ln, &$cond) {
            if (is_dir($l)) {
                return;
            }
            $g = substr($l, $ln);
            $cond[$g] = $g;
        }, false);
        $d = JobDocs::select([], ['Colulmns' => [JobDocs::FD_VALUE]]);
        $list = [];
        foreach ($d as $row) {
            $cp = json_decode($row->value);
            if (!$cp)
                continue;
            if (is_object($cp) && ($cp = igk_getv($cp, 'path'))) {
                $list[$cp] = $cp;
                if (isset($cond[$cp])) {
                    unset($cond[$cp]);
                }
            }
        }
        foreach ($cond as $r) {
            $f = Path::Combine($path, $r);
            Logger::info('unlink: ' . $f);
            @unlink($f);
        }
    }
    /**
     * 
     * @param string $title 
     * @param string $company 
     * @param null|string $references 
     * @return string 
     */
    public static function CreateJobIdentify(string $title, string $company, ?string $references= null){
        $p = implode(':', array_filter([$title, $company, $references]));
        $p = hash('crc32b', StringUtility::Slugify($p));
        return $p;
    }
}