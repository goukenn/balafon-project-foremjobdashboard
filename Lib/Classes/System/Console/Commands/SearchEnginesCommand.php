<?php
// @author: C.A.D. BONDJE DOUE
// @file: SearchEnginesCommand.php
// @date: 20250829 14:46:49
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use com\igkdev\projects\ForemJobDashboard\Models\JobSearchEngines;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Commands\Database\Traits\ManageDatabaseTrait;
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
class SearchEnginesCommand extends JobCommandBase
{

    /**
    * auto generate doc.
    * @var mixed
    */
    var $command = '--forem-job:engines';

    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc='manage search engines';
	/* var $options=[]; */
	/* var $category = ''; */

    /**
    * auto generate doc.
    * @var mixed
    */
    var $usage = '[action] [options]';
	use ManageDatabaseTrait;

    /**
    * auto generate doc.
    */
    public function getModelClass() {
		return JobSearchEngines::class;
	}

    /**
    * auto generate doc.
    * @param mixed $command
    * @param null|string $names
    */
    protected function _handle_add($command, ?string $names=null){
		if ($names){
			array_map(function($i){ 
				$c = trim($i);
				$this->getModelClass()::AddIfNotExists($i, 'https://'.$c.'.com');
			}, explode(',', $names));
		}
	}
}