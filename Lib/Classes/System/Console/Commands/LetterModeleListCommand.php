<?php
// @author: C.A.D. BONDJE DOUE
// @file: LetterModeleListCommand.php
// @date: 20250822 07:19:16
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
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
class LetterModeleListCommand extends JobCommandBase{
    /**
    * auto generate doc.
    * @var mixed
    */
    var $command='--forem-job:letter';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc='manage forem job letter';
	/* var $options=[]; */
	/* var $category = ''; */
	/* var $usage = ''; */
    /**
    * auto generate doc.
    * @param mixed $command
    */
    public function exec($command) { 
		$r = []; 
		if (empty($r)){
			Logger::print('no letter model list');
		}else{
			Logger::print('letter model list');
		}
	}
}