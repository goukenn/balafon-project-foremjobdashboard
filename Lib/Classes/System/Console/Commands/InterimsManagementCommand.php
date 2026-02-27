<?php
// @author: C.A.D. BONDJE DOUE
// @file: InterimsManagementCommand.php
// @date: 20250829 15:55:14
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use com\igkdev\projects\ForemJobDashboard\Models\JobInterims;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Commands\Database\Traits\ManageDatabaseTrait;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
*/
class InterimsManagementCommand extends AppExecCommand{

    /**
    * auto generate doc.
    * @var mixed
    */
    var $command='--forem-job:interims';
	use ManageDatabaseTrait;

    /**
    * auto generate doc.
    */
    public function getModelClass() { 
		return JobInterims::class;
	}

    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc='manage project interims';
	/* var $options=[]; */
	/* var $category = ''; */
	/* var $usage = ''; */

    /**
    * auto generate doc.
    * @param mixed $command
    * @param null|string $names
    */
    protected function _handle_add($command, ?string $names = null)
	{
		if ($names){
			array_map(function($i){ 
				$c = trim($i);
				$this->getModelClass()::AddIfNotExists($i, 'https://'.$c.'.com');
			}, explode(',', $names));
		}
	}
}