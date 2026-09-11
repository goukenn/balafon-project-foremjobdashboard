<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs/Default.phtml
// @desc: view action Jobs/Default
// @date: 20260911 11:24:55
namespace com\igkdev\projects\ForemJobDashboard\Actions\Jobs;

use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Actions\ActionBase;
use IGK\Database\DbQueryCondition;
use IGK\Helper\ViewHelper;
use IGK\System\Database\SQLQueryFieldPrefixOperators;
use IGK\System\Http\Request;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions\Jobs
 * @author C.A.D. BONDJE DOUE
 */
class DefaultAction extends ActionBase
{
    protected function getProjectUser()
    {
        if ($user = $this->getController()->getUserProfile()) {
            return $user->user();
        }
    }
    public function search_post(Request $request)
    {
        $p =  $request->get('search');
        return $this->_payload($p);
    }
    public function index_get(Request $request)
    {
        return $this->_payload(null);
    }
    protected function _payload(?string $create_at = null)
    {
        $user = $this->getProjectUser();
        $params = ViewHelper::GetViewArgs('params');
        $create_at = $create_at ?? igk_getv($params, 0, date("Y-m"));

        // + | search for job only 
        $ad = Jobs::model()->getDataAdapter();
        $cond =    [
            DbQueryCondition::Create([
                '@@' . Jobs::FD_CREATE_AT => $ad->escape_string($create_at) . '%',
                '@@' . Jobs::FN_TITLE() => '%' . $ad->escape_string($create_at) . '%',
            ], DbQueryCondition::OP_OR),
            'jbs_user_id' => $user->jbu_id
        ];
        $total = Jobs::count($cond);
        // + | search for job with enterprise 
        $find = SQLQueryFieldPrefixOperators::FIND;

        $r = Jobs::prepare()
            ->with(JobEnterprises::table(), 'enterprise')
            ->join_left(JobEnterprises::table(), sprintf('%s=%s', JobEnterprises::FN_ID(), Jobs::FD_ENTERPRISE_ID))
            ->with(JobStatusTypes::table(), 'status')
            ->join_left(JobStatusTypes::table(), sprintf('%s=%s', JobStatusTypes::FN_ID(), Jobs::FD_STATUS_ID))
            ->conditions(
                $cond
            )->execute()->to_array();
        return [
            'create_at' => $create_at,
            'result' => $r,
            'total' => $total
        ];
    }
}
