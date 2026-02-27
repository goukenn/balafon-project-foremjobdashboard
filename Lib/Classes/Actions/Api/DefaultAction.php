<?php
// @author: C.A.D. BONDJE DOUE
// @file: Api/Default.phtml
// @desc: view action Api/Default
// @date: 20250616 06:36:13
namespace com\igkdev\projects\ForemJobDashboard\Actions\Api;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Actions\ActionBase;
use IGK\Actions\ApiActionBase;
use IGK\System\Http\Request;
///<summary>view action</summary>
/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions\Api
* @author C.A.D. BONDJE DOUE
*/
class DefaultAction extends ApiActionBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const VERSION = '1.0';

    /**
    * auto generate doc.
    */
    public function index_get(){ 
        return [
            'author'=>IGK_AUTHOR,
            'version'=>self::VERSION,
            'description'=>'REST api to administrate list of job for forem.'
        ];
    }

    /**
    * auto generate doc.
    * @param Jobs $job
    * @param Request $request
    */
    public function index_put(Jobs $job, Request $request){         
        $data = $request->getJsonData(); 
        return $request->error('no json data',400);
    }

    /**
    * auto generate doc.
    * @param Jobs $job
    */
    public function info(Jobs $job){
        return $job->to_array();
    }
}