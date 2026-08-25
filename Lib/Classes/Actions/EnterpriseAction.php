<?php
// @author: C.A.D. BONDJE DOUE
// @file: Enterprise.phtml
// @desc: view action Enterprise
// @date: 20250123 21:54:09
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use com\igkdev\projects\ForemJobDashboard\JobEnterpriseInfo;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use Exception;
use IGK\Actions\ApiActionBase;
use IGK\Database\DbConstants;
use IGK\Helper\Activator;
use IGKException;
use IGK\System\Exceptions\ArgumentTypeNotValidException;
use ReflectionException;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions
 * @author C.A.D. BONDJE DOUE
 */
class EnterpriseAction extends ApiActionBase
{
    /**
     * override handle reponse
     * @param mixed $response 
     * @return bool 
     * @throws Exception 
     */
    protected function _handleResponse($response): bool
    {
        if (igk_is_ajx_demand()){
            return true;
        }
        return !is_array($response);
    }
    /**
    * auto generate doc.
    * @return array
    */
    function index_post($name = null)
    {
        $n = $name ?? igk_getr('enterprise');
        $response = [];
        if (!is_null($n)) {
            $nfield = JobEnterprises::FD_NAME;
            $jobs = [];
            $r = [];
            $query_result = JobEnterprises::prepare()
                ->with(Jobs::table(), 'jobs')
                ->join_left(
                    Jobs::table(),
                    Jobs::FN_ENTERPRISE_ID() . '=' . JobEnterprises::FN_ID()
                )
                ->columns([ 
                    JobEnterprises::table() . '.*',
                    Jobs::FN_ID()
                ])
                ->where(['@@' . $nfield => '%' . $n . '%'])
                ->orderBy([JobEnterprises::FN_NAME() . '|ASC'])
                ->limit(100);
            $query_result = $query_result->execute(true, [DbConstants::CALLBACK_OPTS => function ($row) use (&$jobs, &$r) {
                $j_id = $row->{Jobs::FD_ID};
                $j = null;
                if (!($j = igk_getv($jobs, $j_id))) {
                    $j = Jobs::GetCache(Jobs::FD_ID, $j_id);
                    $jobs[$j_id] = $j;
                }
                if (!isset($r[$row->id])) {
                    $r[$row->id] = (object)igk_array_exclude($row->to_array(), 'jbs_id');
                    $row->jobs = [];
                }
                $c = $r[$row->id];
                if ($j)
                    $c->jobs[] = $j;
                return null;
            }]); 
            $response['enterprises'] = $r;
            $response['search'] = $n;
        }
        return $response;
    }
    /**
     * default index
     * @return void|mixed|IResponse|null 
     */
    public function index(){
        $cond = [];  
        return ['enterprise_count'=>JobEnterprises::count($cond)];
    }
    /**
     * handle enterprise detail
     * @param JobEnterprises $enterprise 
     * @return array{enterprise: \com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises} 
     */
    public function details(JobEnterprises $enterprise){
        if ($i = $enterprise->info){
            $enterprise->info = Activator::CreateNewInstance(JobEnterpriseInfo::class, $i);
        }
        return ['enterprise'=>$enterprise];
    }
}