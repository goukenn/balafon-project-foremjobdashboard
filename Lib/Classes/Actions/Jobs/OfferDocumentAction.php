<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs/OfferDocument.phtml
// @desc: view action Jobs/OfferDocument
// @date: 20250124 17:38:05
namespace com\igkdev\projects\ForemJobDashboard\Actions\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\JobDocTypes as ConstantJobDocTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobContractTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use Exception;
use IGK\Actions\ApiActionBase;
use IGK\Actions\Traits\Authenticator\BearerAuthenticatorTrait;
use IGK\Models\ModelBase;
use IGK\System\Database\IUserProfile;
use IGK\System\Http\ApiResponse;
use IGK\System\Http\JsonResponse;
use IGK\System\Http\StatusCode;
use IGK\System\Http\WebFileContentResponse;
use IGK\System\Http\WebFileResponse;
use IGK\System\Http\WebResponse;
use IGK\System\IO\Path;
use IGKException;
///<summary>view action</summary>
/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions\Jobs
 * @author C.A.D. BONDJE DOUE
 * @security(["OAuth2Auth"])
 * @securityFlow('implicit',authorizationUrl="@/api/docs/swagger.oauth")
 */
class OfferDocumentAction extends ApiActionBase
{
    use BearerAuthenticatorTrait;
    protected function getUserFromToken(bool $update = true, &$token = null): ?ModelBase
    {
        return null;
    }
    protected function userProfileFromApplicationUser(ModelBase $app_user): ?IUserProfile
    {
        return null;
    }
    /**
     * 
     * @return JsonResponse 
     */
    protected function emptyResponse()
    {
        return ApiResponse::EmptyJsonResponse();
    }
    /**
     * just send auth 
     * @return array{auth: string, request: array} 
     */
    public function auth(){
        return ["auth"=>"success", "request"=>$_REQUEST];
    }
    //     function index(){
    //         igk_wln_e("offer");
    //     }
    /**
     * delete all offer's documents 
     * @param Jobs $job 
     * @return bool 
     * @responses()
     * @security(['OAuth2Auth'])
     */
    function offers_delete(Jobs $job)
    {
        if ($docs = $this->documents($job)) {
            $file = [];
            $this->_getFileToDeletes($docs, $file);
            $r = JobDocs::delete([
                JobDocs::FD_JOB_ID => $job->id
            ]);
            if ($r) {
                // + | FS system to delete 
                $this->_unlinkFiles($file);
            }
            return [
                'status' => ($r ? '200' : '400')
            ];
        }
        return $this->emptyResponse();
    }
    private function _getFileToDeletes($docs, &$file)
    {
        foreach ($docs as $k) {
            $c = $k->{JobDocs::FD_VALUE};
            if ($c && ($c = json_decode($c))) {
                list($path) = igk_extract($c, 'path');
                // depth on docement 
                $file[] = [$path, $k->{JobDocs::FD_JOB_DOC_TYPE_ID}];
            }
        }
    }
    /**
     * delete document
     * @param JobDocs $doc 
     * @responses({"200":{}})
     * @security(["OAuth2Auth"])
     * @return void 
     */
    function document_delete(JobDocs $doc)
    {
        $file = [];
        $this->_getFileToDeletes([$doc], $file);
        if ($doc->delete()) {
            $this->_unlinkFiles($file);
            return [];
        }
        return ApiResponse::EmptyJsonResponse();
    }
    /**
     * 
     * @param JobDocs $doc 
     * @return WebFileContentResponse|void 
     * @responses()
     * @throws Exception 
     */
    public function documentContent(JobDocs $doc)
    {
        if (($c = $doc->value) && ($c = json_decode($c))) {
            list($path, $type) = igk_extract($c, 'path|type|description');
            $fileService = $this->getController()->fileService;
            $content = $fileService->fileContent([$path, $doc->job_doc_type_id]);
            $rep = new WebFileContentResponse($content, 200);
            $rep->content_type = $type;
            $rep->cache = 3600;
            return $rep;
        }
    }
    //private function _getDirs
    /**
     * unlnk file 
     * @param mixed $file 
     * @return void 
     */
    private function _unlinkFiles($file)
    {
        $ctrl = $this->getController();
        $dirs = [
            ConstantJobDocTypes::GetCacheData(ConstantJobDocTypes::INFO)->id => $ctrl->getOfferDir(),
            ConstantJobDocTypes::GetCacheData(ConstantJobDocTypes::RESPONSE)->id => $ctrl->getResponseDir()
        ];
        foreach ($file as $k) {
            list($path, $type) = $k;
            $f = Path::CombineAndFlattenPath($dirs[$type], $path);
            if (igk_io_cache_file_exists($f)) {
                @unlink($f);
            }
        }
    }
    /**
     * get offers documents 
     * @param Jobs $job 
     * @return null|array 
     * @responses()
     * @throws IGKException 
     */
    function documents(Jobs $job)
    {
        return JobDocs::prepare()->with(JobDocTypes::table(), 'doctypes')
            ->conditions([
                JobDocs::FD_JOB_ID => $job->id
            ])
            ->execute()
            ->to_array();
    }
    /**
     * get job offer info
     * @param Jobs $job 
     * @return null|array 
     * @responses({"200":{"content":{"application/json":{}}}})
     * @throws IGKException 
     */
    public function offer_get(Jobs $job)
    {
        return Jobs::prepare()
            ->with(JobSourceTypes::table(), 'source')
            ->with(JobUsers::table(), 'user')
            ->with(JobContractTypes::table(), 'contract')
            ->with(JobStatusTypes::table(), 'status')
            ->with(JobEnterprises::table(), 'enterprise')
            ->with(JobRegisterTypes::table(), 'type')
            ->conditions([
                Jobs::FD_ID => $job->id
            ])
            ->execute()->to_array();
    }
    /**
     * 
     * @param Jobs $job 
     * @param JobRegisterTypes $t 
     * @return null|array 
     * @throws IGKException 
     * @responses({"200":{}, "401":{"description":"unauthorize"}})
     */
    public function offer_change_type_post(Jobs $job, JobRegisterTypes $type)
    {
        $u = $this->currentUser;
        if (!$u) {
            throw new \IGKException('operation not allowed', StatusCode::UNAUTHORIZED);
        }
        $cu = JobUsers::GetCache(JobUsers::FD_ID, $job->user_id);
        $access = ($cu->id == $u->id) || $u::auth('admin');
        if (!$access) {
            throw new \IGKException("Access not allowed", 401);
        }
        $job->type_id = $type;
        $job->update();
        return $this->offer_get($job); //$job->to_array();
    }
    // * @securityFlow('implicit',{"authorizationUrl":"/api/auth"})
    // * @security(["BearerAuth", "BasicAuth", "OAuth2Auth"])
    // * @security(["BearerAuth","OAuth2Auth", "BasicAuth"])
    // * @securityFlow('implicit', authorizationUrl="@/api/docs/swagger.oauth", scopes={"read":"read access", "write":"write access"})
    /**
     * @responses({"200":{"content":{"application/json":{}}}})
     * @security(["OAuth2Auth"])
     * @return void 
     */
    public function auth_check_post()
    {
        $token = null;
        if ($obj = igk_server()->getAccessObject()) {
            $token = $obj->getBearerToken();
        }
        return [
            "securityCheck" => '?',
            "token" => $token,
        ];
    }
}