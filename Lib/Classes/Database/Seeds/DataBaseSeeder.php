<?php
// @author: C.A.D. BONDJE DOUE
// @desc: database seeder
// @date: 20240904 16:18:14
namespace com\igkdev\projects\ForemJobDashboard\Database\Seeds;
use com\igkdev\projects\ForemJobDashboard\Models\JobContacts;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprisesContacts;
use ForemJobDashboardController;
use IGK\System\Database\Seeds\SeederBase;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Database\Seeds
* @author C.A.D. BONDJE DOUE
*/
class DataBaseSeeder extends SeederBase{
	public function run(){
	// + | DATABASE Seeder
	// + | [model]::factory(number)->create();
		$enterprises = JobEnterprises::factory(rand(5, 60))->create();
		$contacts = JobContacts::factory(rand(5, 25))->create();
		JobEnterprisesContacts::factory(30, null, [$enterprises, $contacts])->create();
	}
}