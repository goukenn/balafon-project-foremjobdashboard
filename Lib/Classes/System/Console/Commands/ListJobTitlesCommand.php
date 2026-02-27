<?php
// @author: C.A.D. BONDJE DOUE
// @file: ListJobTitlesCommand.php
// @date: 20251103 09:52:02
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
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
class ListJobTitlesCommand extends JobCommandBase
{

    /**
    * auto generate doc.
    * @var mixed
    */
    var $command = '--forem-job:titles';

    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc = 'list job title';

    /**
    * auto generate doc.
    * @var mixed
    */
    var $options = [
		'--fix'=>'fix fake with existing data',
	];

    /**
    * auto generate doc.
    * @var mixed
    */
    var $category = 'forem';

    /**
    * auto generate doc.
    * @var mixed
    */
    var $usage = '[options]';

    /**
    * auto generate doc.
    * @param mixed $command
    */
    public function exec($command)
	{
		$fix = property_exists($command->options, '--fix');
		$key = Jobs::FD_TITLE;
		$query = Jobs::prepare()
			->distinct(true)
			->columns([Jobs::FD_TITLE/*, Jobs::FD_ID*/])
			->orderBy([$key]);
		$g = $query->execute()->to_array();
		// usort($g, function ($a, $b) use ($key) {
		// 	return strcmp($a->{$key}, $b->{$key});
		// });
		$fix_tab = [];
		if ($fix){
				foreach ($g as $row) {
					$t = $row->{Jobs::FD_TITLE};
					$fix_tab[] = $t;
				}
		}
		$pid_c = Jobs::primaryKey();
		foreach ($g as $row) {
			$title = $row->{Jobs::FD_TITLE};
			if ($fix){
				if (igk_str_startwith($title, '@@FAKE:')){
					$ntitle = $fix_tab [rand(0, count($fix_tab)-1)];
					Jobs::update([
						Jobs::FD_TITLE=>$ntitle,
					], [
						Jobs::FD_TITLE=>$title,
					]);
					$title = $ntitle;
				}
			}
			if ($title != trim($title)) {
				if ($job = Jobs::Get($pid_c, $row->{$pid_c})) {
					$title = $job->{Jobs::FD_TITLE} = trim($title);
					$job->save();
				}
			}
			igk_wln($title);
		}
		Logger::info(count($g));
		Logger::success('done');
	}
}