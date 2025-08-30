<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs/Edit.phtml
// @desc: view action Jobs/Edit
// @date: 20250828 11:01:23
namespace com\igkdev\projects\ForemJobDashboard\Actions\Jobs;

use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Actions\ActionBase;

/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions\Jobs
* @author C.A.D. BONDJE DOUE
*/
class EditAction extends ActionBase{
    public function index(?Jobs $job=null){
        $response = [];
        if ($job){
            $response['docs'] = JobDocs::select_all([JobDocs::FD_JOB_ID => $job->id]);
            $response['job'] = $job;
        }
        return $response;
    }
    public function clear_docs_post(Jobs $job){
        igk_wln_e("clear document");
        JobDocs::delete([JobDocs::FD_JOB_ID => $job->id]);
    }
}