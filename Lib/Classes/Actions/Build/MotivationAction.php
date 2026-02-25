<?php
// @author: C.A.D. BONDJE DOUE
// @file: Build/Motivation.phtml
// @desc: view action Build/Motivation
// @date: 20250422 10:43:17
namespace com\igkdev\projects\ForemJobDashboard\Actions\Build;
use com\igkdev\projects\ForemJobDashboard\Models\JobMotivations;
use Exception;
use IGK\Actions\ActionBase;
use IGK\Helper\JSon;
use IGKException;
///<summary>view action</summary>
/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions\Build
* @author C.A.D. BONDJE DOUE
*/
class MotivationAction extends ActionBase{
    /**
     * modivate save 
     * @return array 
     * @throws Exception 
     * @throws IGKException 
     */
    public function save_post(){
        $response = $error = null;
        $obj = igk_extract_obj($_POST, 'lang|intro|ask|conclusion|salutation');
        $i_s = (array)$obj;
        unset($i_s['lang']);
        ($profile = $this->getController()->getUserProfile()) ?? igk_die('missing user profiles', 301);
        $uid = $profile->user()->id;
        if (JobMotivations::insertIfNotExists(["lang"=>$obj->lang, "user_id"=> $uid, "data"=>JSon::Encode($i_s)])){
            $reponse = 'success';
        }else{
            $error = true;
        }
        return compact('response', 'error');
    }
    public function index(){ 
    }
}