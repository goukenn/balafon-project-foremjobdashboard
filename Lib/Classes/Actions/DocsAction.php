<?php
// @author: C.A.D. BONDJE DOUE
// @file: Docs.phtml
// @desc: view action Docs
// @date: 20251112 07:39:31
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use com\igkdev\projects\ForemJobDashboard\EnumAuthorizations;
use com\igkdev\projects\ForemJobDashboard\FJDHooks;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use com\igkdev\projects\ForemJobDashboard\System\IO\Storage;
use IGK\Actions\MiddlewireActionBase; 
use IGK\System\Http\NotAllowedRequestException;
use IGK\System\Http\Request;
use IGK\System\Http\RequestResponseCode;
use IGK\System\IO\Path;
/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions
* @author C.A.D. BONDJE DOUE
*/
class DocsAction extends MiddlewireActionBase{
    /**
     * 
     * @param null|Jobs $job 
     * @return void|mixed|IResponse|null 
     */
    public function index(?Jobs $job=null, ?Request $request=null){
        Jobs::registerMacro('documents', function(){
            return JobDocs::select_all([JobDocs::FD_JOB_ID => $this->id]);
        });  
        // + | --------------------------------------------------------------------
        // + | on job defined get list of documents attached to this job
        // + |
        $response = [
            "_action_"=>'index_get'
        ];
        if ($job) {
            $response['documents'] = $job->documents();
            $response['job'] = $job;
        }
        return $response;
    }
    /**
     * drop 
     * @param JobDocs $doc 
     * @param null|Request $request 
     * @return void 
     * @auth(user|drop)
     */
    public function drop_post(JobDocs $doc, ?Request $request=null){
        $ctrl = $this->getController();
        $user = $ctrl->getUser() ?? igk_die('missing user',true, RequestResponseCode::Forbiden);
        $job_id = $doc->{JobDocs::FD_JOB_ID};
        $job = Jobs::GetCache(Jobs::FD_ID, $job_id);
        $can_drop = true;
        if ($user){
            $job_u = JobUsers::GetCache(JobUsers::FD_GUID, $user->clGuid); 
            $can_drop = $can_drop && $job_u && ($job->user_id == $job_u->id) || $ctrl->isUserAllowedTo(EnumAuthorizations::drop_document); 
        } else {
            $can_drop = false;
        }
        if ($can_drop){
            $cancel =false;
            $storage =null;
            if ($doc->isUserFileDocument($user)){
                $p = igk_getv(json_decode($doc->value), 'path');
                $dir = Path::Combine($ctrl->currentLoginPath($user), $p);
                $storage = new Storage($dir, $ctrl); 
            }
            igk_hook( FJDHooks::FOREM_JOB_DOC_DELETING, [$doc, &$cancel, $user]);
            if (!$cancel && $doc->delete()){
                if ($storage)
                    $storage->unlink();
                $this->notify_success('document deleted');
            }
            $u = '@/docs/'.$job->id.$request->parseOptions(true); 
            $ctrl->doRequest(['request'=>$u, 'method'=>'GET', 'isAjx'=>igk_is_ajx_demand()]);  
        }
        throw new NotAllowedRequestException();
    }
}