<?php
// @author: C.A.D. BONDJE DOUE
// @file: SearchEnginesCommand.php
// @date: 20250829 14:46:49
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use com\igkdev\projects\ForemJobDashboard\Models\JobSearchEngines;
use IGK\Helper\StringUtility;
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
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    var $options=[        
    ]; 
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
    * @return
    */
    public function showUsage()
    {
        $r = parent::showUsage();
        Logger::info("\n".'action: '."\n");
        Logger::info(implode("\n", [
            'add'
        ]));
        return $r;
    }
    /**
    * auto generate doc.
    * @param mixed $command
    * @param null|string $names
    */
    protected function _handle_add($command, ?string $names=null){
		if ($names){
        $d = igk_json_parse($names);
        if (is_object($d)){
            $d = [$d];
        }
			array_map(function($i){ 
                $url = '';
                $c = '';
                if (is_string($i)){
				    $c = trim($i);
                    $url = 'https://'.StringUtility::Slugify($c).'.com';
                }else{
                    $url = igk_getv($i, 'url', '');
                    $i = igk_getv($i, 'name');
                }
				if ($r = $this->getModelClass()::AddIfNotExists($i, $url)){
                    if (($r===true)||$r->isNew()){
                        Logger::success('insert: '.$i);
                    }
                }
			}, is_array($d) ? $d : explode(',', $names));
		}
	}
}