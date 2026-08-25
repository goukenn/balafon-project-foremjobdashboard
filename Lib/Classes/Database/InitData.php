<?php
// @author: C.A.D. BONDJE DOUE
// @date: 20240904 16:18:14
namespace com\igkdev\projects\ForemJobDashboard\Database;
use com\igkdev\projects\ForemJobDashboard\JobDocTypes;
use com\igkdev\projects\ForemJobDashboard\JobEnterpriseValueTypes;
use ForemJobDashboardController; 
use IGK\System\Database\InitBase; 

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database
*/
class InitData extends InitBase{
    /**
    * auto generate doc.
    * @var mixed
    */
    static $RecursiveInit = true;
    /**
    * auto generate doc.
    * @param ForemJobDashboardController $controller
    */
    public static function Init(ForemJobDashboardController $controller){
		// + | itialize your data base
      JobDocTypes::InitData();
      JobEnterpriseValueTypes::InitData();
	}
}