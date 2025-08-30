<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterprisesFactory.php
// @desc: factory JobEnterprisesFactory
// @date: 20240914 08:37:24
namespace com\igkdev\projects\ForemJobDashboard\Database\Factories;
use IGK\System\Database\Factories\FactoryBase;
use IGK\System\Traits\ComposerFakerTrait;
///<summary>factory</summary>
/**
 * factory
 * @package com\igkdev\projects\ForemJobDashboard\Database\Factories
 * @author C.A.D. BONDJE DOUE
 */
class JobEnterprisesFactory extends FactoryBase
{
	use ComposerFakerTrait;
	public function definition(): ?array
	{
		$faker = $this->getFaker();
		$type = igk_getv(['Limited','SA','LTD','Company'], rand(0,3));
		$name = implode(' ', array_filter([$faker->words(rand(1, 3), true),  ($this->can() ? $type : null)]));
		return array(
			'id' => 0,
			'name' => $name,
			'vat' => 'FF' . igk_str_repeat_callback(function () {
				return '.' . str_pad(rand(0, 100), '3', 0);
			}, 3),
			'description' => rand(0, 1) ? $faker->paragraph(rand(2, 3)) : null
		);
	}
}