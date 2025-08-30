<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseListCommand.php
// @date: 20250822 07:12:26
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;

use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use IGK\Helper\JSon as HelperJSon;
use IGK\Helper\JSonEncodeOption;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Logger;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
class EnterpriseListCommand extends JobCommandBase{
	var $command='--forem-job:list';
	var $desc='list enterprise command';
	var $options=[];
	var $category = 'forem-job';
	var $usage = '[options]';
	public function exec($command, string $type='interim') { 

		$r = []; 
		$c = JobEnterprises::select_all();
		foreach($c as $row){
			$r[] = $s = trim($row->name);

			if ($s != $row->name){
				$row->name = $s;
				try{
					$row->update();
				}catch(\Exception $ex){
					$row->delete();
				}
			}
		}

		Logger::print(HelperJSon::Encode($r, JSonEncodeOption::IgnoreEmpty(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
	}
}