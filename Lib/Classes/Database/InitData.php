<?php
// @author: C.A.D. BONDJE DOUE
// @date: 20240904 16:18:14
namespace com\igkdev\projects\ForemJobDashboard\Database;

use com\igkdev\projects\ForemJobDashboard\ContractTypes;
use com\igkdev\projects\ForemJobDashboard\RegisterType;
use com\igkdev\projects\ForemJobDashboard\StatusTypes;
use ForemJobDashboardController;
use IGK\System\Database\InitBase;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Database
* @author C.A.D. BONDJE DOUE
*/
class InitData extends InitBase{
	public static function Init(ForemJobDashboardController $controller){
		// + | itialize your data base
		RegisterType::InitData();

		StatusTypes::InitData(); 

		ContractTypes::InitData();
	}
}