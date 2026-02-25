<?php
// @author: C.A.D. BONDJE DOUE
// @file: Capsulate.phtml
// @desc: view action Capsulate
// @date: 20251031 09:16:09
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use IGK\Actions\ActionBase;
use com\igkdev\projects\ForemJobDashboard\ModelUtilities\MainTaskModelUtility;
use ForemJobDashboardController;
use IGK\System\Http\Request;
/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions
* @author C.A.D. BONDJE DOUE
*/
class CapsulateAction extends ActionBase{
    public function index(?Request $request=null, ?ForemJobDashboardController $ctrl=null){
        list($search) = $request->get('search');
        /**
         * @var MainTaskModelUtility
         */
        $ctrl = $ctrl ?? $this->getController();
        $job  = $ctrl->modelUtility('maintask') ?? igk_die('missing jobs utility');        
        $user = $ctrl->getUserProfile()->user();
        return [
            'job_applications'=>$user ? $job->selectAllUserJobApplication($user, $search) : null,
            'modelUtility'=>$job
        ];
    }
}