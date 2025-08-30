<?php
// @author: C.A.D. BONDJE DOUE
// @file: LetterModeleListCommand.php
// @date: 20250822 07:19:16
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;

use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Logger;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
class LetterModeleListCommand extends JobCommandBase{
	var $command='--forem-job:letter';
	var $desc='manage forem job letter';
	/* var $options=[]; */
	/* var $category = ''; */
	/* var $usage = ''; */
	public function exec($command) { 
		$r = []; 
		if (empty($r)){
			Logger::print('no letter model list');
		}else{
			Logger::print('letter model list');
		}
	}
}