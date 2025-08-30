<?php
// @author: C.A.D. BONDJE DOUE
// @file: InterimsManagementCommand.php
// @date: 20250829 15:55:14
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;

use com\igkdev\projects\ForemJobDashboard\Models\JobInterims;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Commands\Database\Traits\ManageDatabaseTrait;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
class InterimsManagementCommand extends AppExecCommand{
	var $command='--forem-jobs:interims';
	use ManageDatabaseTrait;

	public function getModelClass() { 
		return JobInterims::class;
	}	
	var $desc='manage project interims';
	/* var $options=[]; */
	/* var $category = ''; */
	/* var $usage = ''; */ 

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