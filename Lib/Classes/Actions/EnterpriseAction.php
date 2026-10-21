<?php
// @author: C.A.D. BONDJE DOUE
// @file: Enterprise.phtml
// @desc: view action Enterprise
// @date: 20250123 21:54:09
namespace com\igkdev\projects\ForemJobDashboard\Actions;

use com\igkdev\projects\ForemJobDashboard\JobEnterpriseInfo;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Services\KboService;
use Exception;
use IGK\Actions\ApiActionBase;
use IGK\Database\DbConstants;
use IGK\Helper\Activator;
use IGKException;
use IGK\System\Exceptions\ArgumentTypeNotValidException;
use IGK\System\Http\IResponse;
use IGK\System\Http\Request;
use ReflectionException;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions
 * @author C.A.D. BONDJE DOUE
 */
class EnterpriseAction extends ApiActionBase
{
    /**
     * override handle response
     * @param mixed $response 
     * @return bool 
     * @throws Exception 
     */
    protected function _handleResponse($response): bool
    {
        if (igk_is_ajx_demand()) {
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
    public function index()
    {
        $cond = [];
        return [
            'enteprises' => JobEnterprises::select_all($cond, [
                'Limit' => 10
            ]),
            'enterprise_count' => JobEnterprises::count($cond)
        ];
    }
    /**
     * handle enterprise detail
     * @param JobEnterprises $enterprise
     * @return array{enterprise: \com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises}
     */
    public function details(JobEnterprises $enterprise)
    {
        if ($i = $enterprise->info) {
            $enterprise->info = Activator::CreateNewInstance(JobEnterpriseInfo::class, $i);
        }
        return ['enterprise' => $enterprise];
    }
    /**
     * look up a belgian enterprise in the public KBO/BCE registry. Nothing is stored here:
     * the form is filled client side and saved by the user.
     * @return mixed json {found: bool, error?: string, data?: array}
     */
    public function kbo_post(Request $request)
    {
        $ctrl = $this->getController();
        if (!$ctrl->checkUser(false)) {
            return $this->_json(['found' => false, 'error' => 'unauthorized'], 401);
        }
        $number = KboService::Normalize($request->getFormData()->vat);
        if (!$number) {
            return $this->_json(['found' => false, 'error' => 'invalid']);
        }
        $data = KboService::Fetch($number);
        return $this->_json($data ? ['found' => true, 'data' => $data] : ['found' => false, 'error' => 'not_found']);
    }
    /**
     * copy the KBO/BCE fields of a submitted form to the model
     */
    protected function _bindKbo(JobEnterprises $enterprise, $obj): void
    {
        $v = function ($k) use ($obj) {
            $s = trim((string)$obj->$k);
            return $s === '' ? null : $s;
        };
        $enterprise->{JobEnterprises::FD_LEGAL_FORM} = $v('legal_form');
        $enterprise->{JobEnterprises::FD_PHONE} = $v('phone');
        $enterprise->{JobEnterprises::FD_EMAIL} = $v('email');
        $enterprise->{JobEnterprises::FD_WEBSITE} = $v('website');
        $enterprise->{JobEnterprises::FD_START_DATE} = ($d = $v('start_date')) && strtotime($d) ? date('Y-m-d', strtotime($d)) : null;
        $enterprise->{JobEnterprises::FD_KBO_STATUS} = $v('kbo_status');
        if ($v('kbo_status') || $v('legal_form')) {
            $enterprise->{JobEnterprises::FD_KBO_FETCHED_AT} = $v('kbo_fetched_at') ?: date('Y-m-d H:i:s');
        }
    }
    /**
     * show add enterprise form
     * @return array
     */
    public function add()
    {
        return [];
    }
    /**
     * handle add enterprise form submit
     * @return mixed
     */
    public function add_post(Request $request)
    {
        $obj = $request->getFormData();
        if (!$obj->name) {
            return ['errors' => true] + $this->add();
        }
        $c = JobEnterprises::GetCache(JobEnterprises::FD_NAME, $obj->name, true);
        if ($c) {
            $c->{JobEnterprises::FD_VAT} = $obj->vat ?: null;
            $c->{JobEnterprises::FD_TITLE} = $obj->title;
            $c->{JobEnterprises::FD_DESCRIPTION} = $obj->description;
            $c->{JobEnterprises::FD_ADDRESS} = $obj->address;
            $c->{JobEnterprises::FD_LOCALITY} = $obj->locality;
            $c->{JobEnterprises::FD_SHARE_CAPITAL} = $obj->share_capital !== '' ? $obj->share_capital : null;
            $c->{JobEnterprises::FD_TURNOVER} = $obj->turnover !== '' ? $obj->turnover : null;
            $this->_bindKbo($c, $obj);
            $c->save();
            igk_navto($this->getController()::uri('@/enterprise/details/' . $c->id));
        }
        return ['errors' => true] + $this->add();
    }
    /**
     * show edit enterprise form
     * @param JobEnterprises $enterprise
     * @return array
     */
    public function edit(JobEnterprises $enterprise)
    {
        return ['enterprise' => $enterprise];
    }
    /**
     * handle edit enterprise form submit
     * @param JobEnterprises $enterprise
     * @return mixed
     */
    public function edit_post(JobEnterprises $enterprise, Request $request)
    {
        $obj = $request->getFormData();
        $enterprise->{JobEnterprises::FD_NAME} = $obj->name ?: $enterprise->name;
        $enterprise->{JobEnterprises::FD_VAT} = $obj->vat ?: null;
        $enterprise->{JobEnterprises::FD_TITLE} = $obj->title;
        $enterprise->{JobEnterprises::FD_DESCRIPTION} = $obj->description;
        $enterprise->{JobEnterprises::FD_ADDRESS} = $obj->address;
        $enterprise->{JobEnterprises::FD_LOCALITY} = $obj->locality;
        $enterprise->{JobEnterprises::FD_SHARE_CAPITAL} = $obj->share_capital !== '' ? $obj->share_capital : null;
        $enterprise->{JobEnterprises::FD_TURNOVER} = $obj->turnover !== '' ? $obj->turnover : null;
        $this->_bindKbo($enterprise, $obj);
        $vat_warning = false;
        if ($obj->vat && !preg_match('/^BE0?\d{9,10}$/', str_replace([' ', '.'], '', strtoupper(trim($obj->vat))))) {
            $vat_warning = true;
        }
        $enterprise->save();
        if (!$vat_warning) {
            igk_navto($this->getController()::uri('@/enterprise/details/' . $enterprise->id));
        }
        return ['enterprise' => $enterprise, 'vat_warning' => $vat_warning];
    }
    /**
     * get list of job for 
     * @param JobEnterprises $enterprise 
     * @return array|array<string|int, Jobs>|null|mixed 
     */
    public function jobs_get(JobEnterprises $enterprise, Request $request)
    {
        $qinfo = $request->getQueryInfo();
        $limit = igk_getv($qinfo->query_options, 'limit');
        $conditions = [
            Jobs::FD_ENTERPRISE_ID => $enterprise->id
        ];
        return [
            'enterprise' => $enterprise,
            'jobs' => Jobs::select_all($conditions, ['Limit' => $limit]),
            'total' => Jobs::count($conditions),
        ];
    }
}
