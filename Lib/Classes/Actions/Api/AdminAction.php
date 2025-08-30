<?php
// @author: C.A.D. BONDJE DOUE
// @file: Api/Admin.phtml
// @desc: view action Api/Admin
// @date: 20250616 06:38:09
namespace com\igkdev\projects\ForemJobDashboard\Actions\Api;
use IGK\Actions\ActionBase;
use IGK\Actions\ApiActionBase;
///<summary>view action</summary>
/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions\Api
* @author C.A.D. BONDJE DOUE
* @security([BearerAuth])
* @auth(admin, strict=true)
*/
class AdminAction extends ApiActionBase{
    public function job_post(){
        return [];
    }
}