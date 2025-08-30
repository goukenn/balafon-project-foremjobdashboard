<?php
// @author: C.A.D. BONDJE DOUE
// @file: Settings.phtml
// @desc: view action Settings
// @date: 20250513 21:33:38
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use IGK\Actions\ActionBase;
use IGK\Models\Users;
///<summary>view action</summary>
/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions
* @author C.A.D. BONDJE DOUE
*/
class SettingsAction extends ActionBase{
    /**
     * retrive job list 
     * @return array{joblist: array} 
     */
    public function joblist(?JobUsers $user=null){
        $cur_user = $this->getController()->getUserProfile()->user();
        if (is_null($user) || ($user->id == $cur_user->id)){
        }
        $user = $user ?? $cur_user;
        $condition = ($user)? [
            Jobs::FD_USER_ID=>$user->id
        ]: []; 
        $r = Jobs::select_all($condition);
        return $r;
    }
}