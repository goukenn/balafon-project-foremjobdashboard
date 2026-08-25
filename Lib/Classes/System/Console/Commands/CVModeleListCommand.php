<?php
// @author: C.A.D. BONDJE DOUE
// @file: CVModeleListCommand.php
// @date: 20250822 07:19:24
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
class CVModeleListCommand extends JobCommandBase{
    /**
    * auto generate doc.
    * @var mixed
    */
    var $command='--forem-job:cv';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc='manage forem job cv';
	/* var $options=[]; */
	/* var $category = ''; */
    /**
    * auto generate doc.
    * @var mixed
    */
    var $usage = '';
    /**
    * auto generate doc.
    * @param mixed $command
    */
    public function exec($command) { 
		$r = []; 
		if (empty($r)){
			Logger::print('no cv model list');
		}else{
			Logger::print('cv model list');
		}
	}
}