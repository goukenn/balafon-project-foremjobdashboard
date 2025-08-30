<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobsFactory.php
// @desc: factory JobsFactory
// @date: 20240908 11:46:30
namespace com\igkdev\projects\ForemJobDashboard\Database\Factories;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\ModelUtilities\MainTaskModelUtility;
use IGK\System\Database\Factories\FactoryBase;
use IGK\System\Traits\ComposerFakerTrait;
use IGKException;
///<summary>factory</summary>
/**
 * factory
 * @package com\igkdev\projects\ForemJobDashboard\Database\Factories
 * @author C.A.D. BONDJE DOUE
 */
class JobsFactory extends FactoryBase
{
	use ComposerFakerTrait;
	/**
	 * override create to create a fake jobs
	 * @return null|array|mixed 
	 * @throws IGKException 
	 */
	public function create(): array
	{
		$faker = $this->getFaker();
		$result = [];
		$jb_user = igk_getv($this->data, "jb_user");
		$jb_number = $this->count;
		$ctrl = $this->model->getController();
		$max_desc = $this->model->getTableColumnInfo()[Jobs::FD_DESCRIPTION]->clTypeLength;
		if (($main = $ctrl->modelUtility('MainTask')) instanceof MainTaskModelUtility) {
			while ($jb_number > 0) {
				$jb_number--;
				$row = $job = $main->addJob($faker->sentence(rand(5, 10)), $jb_user);
				if (is_bool($job) && $job) {
					$row = Jobs::select_row(Jobs::last_id());
				} else {
					if (!$row->isNew()) {
						igk_die("row not new");
					}
				}
				$row->description = substr( $faker->paragraphs(rand(1, 4), true), 0, $max_desc);
				$row->update();
				$result[] = $row;
			}
		}
		return $result;
	}
	public function definition(): ?array
	{
		return null;
	}
}