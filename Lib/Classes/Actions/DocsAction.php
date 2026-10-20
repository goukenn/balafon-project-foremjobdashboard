<?php
// @author: C.A.D. BONDJE DOUE
// @file: Docs.phtml
// @desc: view action Docs
// @date: 20251112 07:39:31
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use com\igkdev\projects\ForemJobDashboard\EnumAuthorizations;
use com\igkdev\projects\ForemJobDashboard\FJDHooks;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use com\igkdev\projects\ForemJobDashboard\System\IO\Storage;
use IGK\Actions\MiddlewireActionBase;
use IGK\System\Http\NotAllowedRequestException;
use IGK\System\Http\Request;
use IGK\System\Http\RequestResponseCode;
use IGK\System\IO\Path;
use function igk_resources_gets as __;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions
 * @author C.A.D. BONDJE DOUE
 */
class DocsAction extends MiddlewireActionBase
{
    /**
     * auto generate doc.
     * @return void|mixed|IResponse|null
     */
    public function index(?Jobs $job = null, ?Request $request = null)
    {
        Jobs::registerMacro('documents', function () {
            return JobDocs::select_all([JobDocs::FD_JOB_ID => $this->id]);
        });
        // + | --------------------------------------------------------------------
        // + | on job defined get list of documents attached to this job
        // + |
        $response = [
            "_action_" => 'index_get'
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
    public function drop_post(JobDocs $doc, ?Request $request = null)
    {
        $ctrl = $this->getController();
        $user = $ctrl->getUser() ?? igk_die('missing user', true, RequestResponseCode::Forbidden);
        $job_id = $doc->{JobDocs::FD_JOB_ID};
        $job = Jobs::GetCache(Jobs::FD_ID, $job_id);
        $can_drop = true;
        if ($user) {
            $job_u = JobUsers::GetCache(JobUsers::FD_GUID, $user->clGuid);
            $can_drop = $can_drop && $job_u && ($job->user_id == $job_u->id) || $ctrl->isUserAllowedTo(EnumAuthorizations::drop_document);
        } else {
            $can_drop = false;
        }
        if ($can_drop) {
            $cancel = false;
            $storage = null;
            if ($doc->isUserFileDocument($user)) {
                $p = igk_getv(json_decode($doc->value), 'path');
                $dir = Path::Combine($ctrl->currentLoginPath($user), $p);
                $storage = new Storage($dir, $ctrl);
            }
            igk_hook(FJDHooks::FOREM_JOB_DOC_DELETING, [$doc, &$cancel, $user]);
            if (!$cancel && $doc->delete()) {
                if ($storage)
                    $storage->unlink();
                $this->notify_success('document deleted');
            }
            $u = '@/docs/' . $job->id . $request->parseOptions(true);
            $ctrl->doRequest(['request' => $u, 'method' => 'GET', 'isAjx' => igk_is_ajx_demand()]);
        }
        throw new NotAllowedRequestException();
    }
    /**
     * post new job to user
     * @param Jobs $job 
     * @return void 
     */
    public function index_post(Jobs $job, $type = null, ?Request $request = null)
    {
        $ctrl = $this->getController();
        $type = $type ?? igk_getr('type') ?? $this->die(500, 'missing require document type');
        $user = $this->currentUser() ?? $this->die(RequestResponseCode::Forbidden, 'current user is missing');
        $fc_store = function ($job, $s, $responseType, $force_insert = false) {
            $cond = [
                JobDocs::FD_JOB_ID => $job->id,
                JobDocs::FD_JOB_DOC_TYPE_ID => $responseType->id,
            ];
            if (!$force_insert && ($hvi = JobDocs::select_row($cond))) {
                $hvi->{JobDocs::FD_VALUE} =  $s;
                $hvi->save();
            } else {
                $cond[JobDocs::FD_VALUE] = $s;
                JobDocs::insert($cond);
            }
        };
        $params = [$job->{Jobs::FD_ID}];
        $tid = JobDoctypes::GetCache('id', $type);
        $status = 200;
        $response = [];
        if ($c = $tid->cardinality) {
            $cond = [
                JobDocs::FD_JOB_ID => $job->id,
                JobDocs::FD_JOB_DOC_TYPE_ID => $tid->id,
            ];
            $tc = JobDocs::count($cond);
            if ($tc >= $c) {
                $status = RequestResponseCode::NotAcceptable;
                $response['message'] = __('contains maximun of allowed document');
                return compact('status', 'response');
            }
        }
        if (($file = igk_getv($_FILES, 'file')) && ($file['error'] == 0)) {
            $type = igk_getv($file, 'type') ?? 'application/pdf';
            $ext = igk_getv(['application/pdf' => '.pdf', 
            'text/plain' => '.txt',
            'text/markdown'=>'.md',
             'image/png' => '.png'], $type);
            $path = uniqid('doc') . $ext;
            $dir = $ctrl->currentLoginPath();
            $storage = new Storage($dir, $ctrl);
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            if ($storage->moveUpload($file['tmp_name'], $path)) {
                $s =  json_encode((object)[
                    'path' => $path,
                    'type' => $file['type'],
                    'size' => $file['size'],
                    'remark'=> igk_getr('msg')
                ], JSON_UNESCAPED_UNICODE);
                $fc_store($job, $s, $tid, true);
            } else {
                $this->die(RequestResponseCode::NotAcceptable);
            }
        } else if ($msg = igk_getr('msg')) {
            $msg = str_replace("\r", "", $msg);
            $s =  json_encode((object)[
                'content' => $msg,
                'type' => 'template',
                'size' => strlen($msg)
            ], JSON_UNESCAPED_UNICODE);
            $fc_store($job, $s, $tid, true);
        }
        return compact('status', 'response');
    }
}