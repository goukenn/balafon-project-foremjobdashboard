<?php
// @author: C.A.D. BONDJE DOUE
// @file: Enterprise.phtml
// @desc: view action Enterprise
// @date: 20250123 21:54:09
namespace com\igkdev\projects\ForemJobDashboard\Actions;

use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use Exception;
use IGK\Actions\ApiActionBase;
use IGK\Database\DbConstants;
use IGKException;
use IGK\System\Exceptions\ArgumentTypeNotValidException;
use ReflectionException;

///<summary>view action</summary>
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
     * 
     * @param mixed $name 
     * @return array 
     * @throws IGKException 
     * @throws ArgumentTypeNotValidException 
     * @throws ReflectionException 
     * @throws Exception 
     */
    function index_post($name = null)
    {
        $n = $name ?? igk_getr('enterprise');
        $response = [];
        if (!is_null($n)) {
            $nfield = JobEnterprises::FD_NAME;
            // igk_environment()->querydebug = 1;
            // $r = JobEnterprises::select_all(['@@'.$nfield=>'%'.$n.'%'], 
            // ['OrderBy'=>[$nfield.'|ASC']]);
            $jobs = [];
            $r = [];
            $query_result = JobEnterprises::prepare()
                ->with(Jobs::table(), 'jobs')
                ->join_left(
                    Jobs::table(),
                    Jobs::FD_ENTERPRISE_ID() . '=' . JobEnterprises::FD_ID()
                )
                ->columns([
                    // JobEnterprises::FD_ID(),
                    // JobEnterprises::FD_NAME(),
                    JobEnterprises::table() . '.*',
                    Jobs::FD_ID()
                ])
                ->where(['@@' . $nfield => '%' . $n . '%'])
                ->orderBy([JobEnterprises::FD_NAME() . '|ASC'])
                ->limit(100);
            // ->distinct(true);
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
    
}
