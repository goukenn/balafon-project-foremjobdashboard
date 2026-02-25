<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobsImportMapping.php
// @desc: importer from  JobsImportMapping
// @date: 20250225 13:00:59
namespace com\igkdev\projects\ForemJobDashboard\Database\Import;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use IGK\Helper\Activator;
use IGK\Models\Users;
use IGK\System\Database\Import\DbModelImporterMap;
use IGKException;
///<summary></summary>
/**
 * 
 * @package com\igkdev\projects\ForemJobDashboard\Database\Import
 * @author C.A.D. BONDJE DOUE
 */
class JobsImportMapping extends DbModelImporterMap
{
    private $m_loading;
    /**
     * entry import data
     */
    protected function _onImportData(array $data)
    {
        if (($info = Activator::CreateNewInstance(JobImportInfo::class, $data)) instanceof JobImportInfo) {
            return parent::_onImportData((array)$info);
        }
    }
    /**
     * 
     * @param array $data 
     * @param mixed $model_classe 
     * @return bool 
     */
    protected function _onLoadData(array $data, string $model_classe , & $row):bool
    {
        $row = null;
        $ctrl = $model_classe::model()->getController();
        list($enterprise, $jobs) = igk_extract($data,'enterprise|jobs');
        $enterprise_id = $enterprise->id;
        $status_id = $contact_id = $type_id = $user_id = null;
        $user_profile = $ctrl->getUserProfile();
        if ($user_profile){
            $user_id = $user_profile->user()->id;// $user->clId;
        }else{
            return true;
        }
        while(count($jobs)>0){
            if(($q = array_shift($jobs)) instanceof JobEntryImportInfo){
                // + insert job offer 
                $from_id = -1;
                $contract_id = -1;
                if($r = Jobs::AddIfNotExists(igk_create_guid(),$q->title, $from_id,
                 $contract_id, $type_id, $status_id, $enterprise_id, $contact_id, 
                 $user_id,
                 $q->description,
                 $q->summary,
                 $q->salary,
                 $q->path,
                 $q->printable)){
                    $row = $r;
                     $this->p_inserted++;
                 }
            }
        }
        return true;
    }
    public function __construct(ModelBase $model)
    {
        parent::__construct($model);
        $this->m_loading = igk_createobj();
        $this->addFieldListener('jobs', function (& $raw, $property) {
            $v = igk_getv($raw, $property);
            if (empty($v)){
                return;
            }
            if (!is_array($v)){
                $v = [$v];
            }
            // transform to job entry definitions . that require enterprise 
            $tq = [];
            while(count($v)>0){
                $q = array_shift($v);
                $tq[] = Activator::CreateNewInstance(JobEntryImportInfo::class, $q);
            }
            $raw[$property] = $tq;
        });
        $this->addFieldListener('enterprise', function (&$raw, string $property) {
            if (!isset($this->m_loading->enterprise))
                $this->m_loading->enterprise = [];
            ($v = igk_getv($raw, $property)) && (
                $v = strtoupper($v)
            );
            if ($v && !isset($this->m_loading->enterprise[$v])) {
                $r = null;
                if (!($r = igk_getv($this->m_loading->enterprise, $v))) {
                    $r = JobEnterprises::AddIfNotExists(
                        $v,
                        igk_getv($raw, 'vat'),
                        igk_getv($raw, 'title'),
                        igk_getv($raw, 'description'),
                    );
                    $this->m_loading->enterprise[$v] = $r;
                }
                $raw[$property] = $r;
            }
        });
    }
/**
 * 
 * @return array 
 * @throws IGKException 
 */
    public function export(): array
    {
        $ctrl = Jobs::model()->getController();
        $c = [
            Jobs::FD_ENTERPRISE_ID
        ];
        $enterprises = Jobs::prepare()->distinct(true)
        ->columns([$c[0]])
        ->execute()->to_array();
        $v_out = [];
        $profile = $ctrl->getUserProfile();
        $for = $profile ? $profile->user()->id : null;
        foreach($enterprises as $e){
            $e = $e->{$c[0]};
            if (!$e){
                continue;
            }
            $inf = new JobImportInfo;
            if (($v_ce = JobEnterprises::GetCache(JobEnterprises::FD_ID, $e)) instanceof JobEnterprises){
                $inf->title = $v_ce->title;
                $inf->description = $v_ce->description;
                $inf->vat = $v_ce->vat;
            }
            $cond = [
                Jobs::FD_ENTERPRISE_ID=>$e
            ];
            if ($for){
                $cond[Jobs::FD_USER_ID] = $for;
            }
            $jobs = Jobs::select_all($cond);
            foreach($jobs as $t){
                if (!$inf->jobs){
                    $inf->jobs = [];
                }
                /**
                 * @var Jobs $t
                 */
                $l = new JobEntryImportInfo;
                $l->title = $t->title;
                $l->date = $t->Create_At;
                $l->description = $t->description;
                $l->summary = $t->summary;
                $l->salary = $t->salary;
                $l->type= JobRegisterTypes::GetCache(JobRegisterTypes::FD_ID, $t->type_id)->name;
                $l->from = JobSourceTypes::GetCache(JobSourceTypes::FD_ID, $t->from_id)->name;
                if ($f = $t->user_id){
                    // + | retrieve profile user login
                    $l->for = Users::GetCache(Users::FD_CL_GUID,  JobUsers::GetCache(JobUsers::FD_ID, $f)->guid)->clLogin;
                }
                $inf->jobs[] = $l;
             }
            $v_out[] = $inf;
        }
        return $v_out;
    }
}