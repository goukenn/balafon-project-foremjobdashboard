<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs/Edit.phtml
// @desc: view action Jobs/Edit
// @date: 20250828 11:01:23
namespace com\igkdev\projects\ForemJobDashboard\Actions\Jobs;

use com\igkdev\projects\ForemJobDashboard\Actions\DocsAction;
use com\igkdev\projects\ForemJobDashboard\ContactDataInfo;
use com\igkdev\projects\ForemJobDashboard\Models\JobContacts;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use IGK\Actions\ActionBase;
use IGK\Helper\Activator;
use IGK\Helper\JSon;
use IGK\Helper\ViewHelper;
use IGK\System\Http\Request;
use com\igkdev\projects\ForemJobDashboard\SourceTypes as ForemJobDashboardSourceTypes;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions\Jobs
 * @author C.A.D. BONDJE DOUE
 */
class EditAction extends ActionBase
{
    /**
     * auto generate doc.
     * @param null|Jobs $job
     */
    public function index(?Jobs $job = null)
    {
        $response = [];
        if ($job) {
            $response['docs'] = JobDocs::select_all([JobDocs::FD_JOB_ID => $job->id]);
            $response['job'] = $job;
        }
        return $response;
    }
    /**
     * auto generate doc.
     * @param Jobs $job
     */
    public function clear_docs_post(Jobs $job)
    {
        JobDocs::delete([JobDocs::FD_JOB_ID => $job->id]);
    }
    /**
     * handle post index 
     * @return void 
     */
    public function index_post(Jobs $job, Request $request)
    {
        $ctrl = $this->getController();
        $row = $job;
        $obj = $request->getFormData();
        if ($obj->title) {
            $desc = $obj->description;
            $desc = str_replace("\r", "", $desc);
            $obj->description = substr(preg_replace("/\n+/", "\n", $desc), 0, 2500);
            $obj->summary = substr($obj->summary ?? $obj->description, 0, 2500);
            $e_utility = $ctrl->modelUtility('enterprise');
            $row->{Jobs::FD_TITLE} = $obj->title;
            $row->{Jobs::FD_DESCRIPTION} = $obj->description;
            $row->{Jobs::FD_SUMMARY} = $obj->summary;
            $row->{Jobs::FD_FROM_ID} = $obj->from ?? JobSourceTypes::GetCacheColumn(
                JobSourceTypes::FD_ID,
                ForemJobDashboardSourceTypes::WEB
            );
            $row->{Jobs::FD_STATUS_ID} = $obj->status ?? $row->{Jobs::FD_STATUS_ID};
            $e = $obj->enterprise;
            $c_eid = Jobs::FD_ENTERPRISE_ID;
            $row->{$c_eid} = $e ? $e_utility->registerEnterprise($e) : null;
            $row->{Jobs::FD_CATEGORY_ID} = $obj->category;
            $row->{Jobs::FD_TYPE_ID} = $obj->regtype;
            $row->{Jobs::FD_IS_IMPORTANT} = $obj->is_important ? 1 : 0;
            $row->save();
            if ($obj->forem_ref) {
                $row->attachForemReference($obj->forem_ref);
            }
        }

        return $this->index();
    }
    public function docs(Jobs $job, $type = null, ?Request $request = null)
    {
        $ctrl = $this->getController();
        $fname = ViewHelper::GetViewArgs('fname');
        if ($request->method('POST')) {
            DocsAction::CreateInstance($ctrl)->index_post($job, $type);
        }
        igk_navto($ctrl::uri($fname . '/' . $job->{Jobs::FD_ID}));
    }
    public function contact(Jobs $job, ?Request $request = null)
    {
        if (!$request->method('POST')) {
            return;
        }
        $ctrl = $this->getController();
        $fname = ViewHelper::GetViewArgs('fname');
        $data = $request->getFormData();
        $obj = igk_extract_obj($data, 'name|email|phone|address');
        $l = Activator::CreateNewInstance(ContactDataInfo::class, $obj);
        $r = JobContacts::Add('-', $obj->name, null, null, JSon::EncodeWithNoEmpty($l));
        if ($r) {
            $job->{JOBS::FD_CONTACT_ID} = $r->{JobContacts::FD_ID};
            $job->save();
        }
        igk_navto($ctrl::uri($fname . '/' . $job->{Jobs::FD_ID}));
    }
}
