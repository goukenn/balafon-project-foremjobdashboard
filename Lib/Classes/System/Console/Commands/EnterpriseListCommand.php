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
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
*/
class EnterpriseListCommand extends JobCommandBase{
    /**
    * auto generate doc.
    * @var mixed
    */
    var $command='--forem-job:list';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc='list enterprise command';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $options=[];
    /**
    * auto generate doc.
    * @var mixed
    */
    var $category = 'forem-job';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $usage = '[options]';
    /**
    * auto generate doc.
    * @param mixed $command
    * @param string $type
    */
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