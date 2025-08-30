<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobForemJobsFactory.php
// @desc: factory JobForemJobsFactory
// @date: 20240908 12:13:49
namespace com\igkdev\projects\ForemJobDashboard\Database\Factories;
use com\igkdev\projects\ForemJobDashboard\ModelUtilities\MainTaskModelUtility;
use IGK\System\Database\Factories\FactoryBase;
use TBN\ModelUtilities\TaskModelUtility;
///<summary>factory</summary>
/**
* factory
* @package com\igkdev\projects\ForemJobDashboard\Database\Factories
* @author C.A.D. BONDJE DOUE
*/
class JobForemJobsFactory extends FactoryBase{
	public function create():?array{
		if (!$this->data)
			return parent::create();
		$r = [];
		$c = $this->count;
		$task = $this->modelUtility('MainTask');
		list($i, $jobs) = igk_extract($this->data, "rand_indices|jobs");
		while($c>0){
			if ($task instanceof MainTaskModelUtility){
				$job = $jobs[$i[0]];
				$b = $task->registerForemJob($job, date("00Ymd0").$job->id);
				array_shift($i);
				$r[] = $b;
			}
			$c--;
		}
		return $r;
	}
	public function definition(): ?array{
		return null; 
	// 	array (
	//   'id' => 0,
	//   'job_id' => 0,
	//   'reference' => NULL,
	//   'description' => NULL,
	//   'Create_At' => 'Now()',
	//   'Update_At' => 'Now()',
	// );
	}
}