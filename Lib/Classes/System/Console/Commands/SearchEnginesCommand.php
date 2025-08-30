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
 * 
 * @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
 * @author C.A.D. BONDJE DOUE
 */
class SearchEnginesCommand extends JobCommandBase
{
	var $command = '--forem-jobs:engines';
	var $desc='manage search engines';
	/* var $options=[]; */
	/* var $category = ''; */
	var $usage = '[action] [options]';
	use ManageDatabaseTrait;

	public function getModelClass() {
		return JobSearchEngines::class;
	} 
	protected function _handle_add($command, ?string $names=null){
		if ($names){
			array_map(function($i){ 
				$c = trim($i);
				$this->getModelClass()::AddIfNotExists($i, 'https://'.$c.'.com');
			}, explode(',', $names));
		}
	}
}
