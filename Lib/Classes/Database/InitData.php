<?php
// @author: C.A.D. BONDJE DOUE
// @date: 20240904 16:18:14
namespace com\igkdev\projects\ForemJobDashboard\Database;
use ForemJobDashboardController; 
use IGK\System\Database\InitBase; 
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Database
* @author C.A.D. BONDJE DOUE
*/
class InitData extends InitBase{
	static $RecursiveInit = true;
	public static function Init(ForemJobDashboardController $controller){
		// + | itialize your data base
		// RegisterType::InitData();
		// ContractTypes::InitData(); 
	}
}