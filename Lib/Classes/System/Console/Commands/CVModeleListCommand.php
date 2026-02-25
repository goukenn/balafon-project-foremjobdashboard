<?php
// @author: C.A.D. BONDJE DOUE
// @file: CVModeleListCommand.php
// @date: 20250822 07:19:24
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Logger;
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
class CVModeleListCommand extends JobCommandBase{
	var $command='--forem-job:cv';
	var $desc='manage forem job cv';
	/* var $options=[]; */
	/* var $category = ''; */
	var $usage = '';
	public function exec($command) { 
		$r = []; 
		if (empty($r)){
			Logger::print('no cv model list');
		}else{
			Logger::print('cv model list');
		}
	}
}