<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs/Default.phtml
// @desc: view action Jobs/Default
// @date: 20260911 11:24:55
namespace com\igkdev\projects\ForemJobDashboard\Actions\Jobs;

use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\StatusTypes;
use IGK\Actions\ActionBase;
use IGK\Database\DbQueryCondition;
use IGK\Helper\StringUtility;
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
        try{
        return $this->_payload(null);
        }
        catch(\Exception $ex){

        }
        return [];
    }
    protected function _payload(?string $create_at = null)
    {
        $user = $this->getProjectUser() ?? igk_die('missing project user');
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
        // + | jobs to follow up first (oldest follow-up date first), stable for the rest
        $today = date('Y-m-d');
        $due = function ($row) use ($today) {
            $f = $row->{Jobs::FD_FOLLOW_AT};
            $closed = isset($row->status->{JobStatusTypes::FD_NAME}) && $row->status->{JobStatusTypes::FD_NAME} == StatusTypes::CLOSED;
            return (!$closed && $f && substr($f, 0, 10) <= $today) ? substr($f, 0, 10) : null;
        };
        $index = 0;
        $keyed = array_map(function ($row) use ($due, &$index) {
            return [$due($row), $index++, $row];
        }, $r);
        usort($keyed, function ($a, $b) {
            if (($a[0] === null) !== ($b[0] === null)) {
                return $a[0] === null ? 1 : -1;
            }
            return [$a[0], $a[1]] <=> [$b[0], $b[1]];
        });
        $r = array_column($keyed, 2);
        return [
            'create_at' => $create_at,
            'result' => $r,
            'total' => $total
        ];
    }
    /**
     * keep the duplicate with the nearest (most recent) create date, delete the rest
     */
    public function merge_post(string $group)
    {
        $rows = Jobs::findDuplicateGroups($this->getProjectUser()->jbu_id)[$group] ?? [];
        if (count($rows) < 2) {
            return;
        }
        igk_wln("mergin ", $group, $rows);
        igk_environment()->querydebug = 1;
        usort($rows, function ($a, $b) {
            return strcmp($b->{Jobs::FD_CREATE_AT}, $a->{Jobs::FD_CREATE_AT});
        });
        $owner = array_shift($rows);
        Jobs::clearDuplicates($rows, $owner);
    }
   
    /**
     * delete every job in a duplicate group
     */
    public function delete_all_post(string $group)
    {
        $rows = Jobs::findDuplicateGroups($this->getProjectUser()->jbu_id)[$group] ?? [];
        Jobs::clearDuplicates($rows);
    }
}