<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseCommand.php
// @date: 20250827 10:55:32
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Logger;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
*/
class EnterpriseCommand extends JobCommandBase{
    /**
    * auto generate doc.
    * @var mixed
    */
    var $command='--forem-job:enterprise';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc='enterprise manager';
	/* var $options=[]; */
	/* var $category = ''; */
    /**
    * auto generate doc.
    * @var mixed
    */
    var $usage = 'action [options]';
    /**
    * auto generate doc.
    * @param mixed $command
    * @param null|string $action
    * @param mixed ...$params
    */
    public function exec($command, ?string $action=null, ...$params) {
		!$action && igk_die('required action');
		if (method_exists($this, $fc = '_action_'.$action)){
				$arg = [$command];
				array_push($arg, ...$params);
				call_user_func_array([$this, $fc], $arg);
		} else {
			Logger::danger('missing ['.$action.'] action ');
		}
	}
    /**
    * auto generate doc.
    * @param mixed $command
    * @param mixed ...$params
    */
    public function _action_add($command, ...$params){
		while(count($params)){
			$q = array_shift($params);
			array_map(function($a){
				if (empty(trim($a))) return;
				$r = JobEnterprises::insertIfNotExists([JobEnterprises::FD_NAME=>trim($a)]);
				Logger::info('add '.$a . ' : '.$r);
			}, explode(',', $q));
		}
	}
}