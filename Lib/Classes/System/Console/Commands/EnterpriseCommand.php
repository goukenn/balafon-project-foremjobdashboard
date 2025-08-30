<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseCommand.php
// @date: 20250827 10:55:32
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;

use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Logger;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
class EnterpriseCommand extends JobCommandBase{
	var $command='--forem-job:enterprise';
	var $desc='enterprise manager';
	/* var $options=[]; */
	/* var $category = ''; */
	var $usage = 'action [options]';
	public function exec($command, ?string $action=null, ...$params) {
		!$action && igk_die('required action');
		if (method_exists($this, $fc = '_action_'.$action)){
			call_user_func_array([$this, $fc], [$command, ...$params]);
		} else {
			Logger::danger('missing ['.$action.'] action ');
		}
	}
	public function _action_add($command, ...$params){
		//igk_wln_e('calling .... ', $params);
		while(count($params)){
			$q = array_shift($params);
			array_map(function($a){
				if (empty(trim($a))) return;
				JobEnterprises::insertIfNotExists([JobEnterprises::FD_NAME=>trim($a)]);
			}, explode(',', $q));
		}

	}
}