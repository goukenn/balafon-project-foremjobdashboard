<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobContactsFactory.php
// @desc: factory JobContactsFactory
// @date: 20240914 08:57:18
namespace com\igkdev\projects\ForemJobDashboard\Database\Factories;
use com\igkdev\projects\ForemJobDashboard\JobContactData;
use IGK\Helper\JSon;
use IGK\System\Database\Factories\FactoryBase;
use IGK\System\Traits\ComposerFakerTrait;
///<summary>factory</summary>
/**
 * factory
 * @package com\igkdev\projects\ForemJobDashboard\Database\Factories
 * @author C.A.D. BONDJE DOUE
 */
class JobContactsFactory extends FactoryBase
{
	use ComposerFakerTrait;

    /**
    * auto generate doc.
    */
    function can(){
		return rand(0,1)===1;
	}

    /**
    * auto generate doc.
    * @return ?array
    */
    public function definition(): ?array
	{
		$v_faker = $this->getFaker();
		$v_data = $this->can() ? new JobContactData : null;
		if ($v_data instanceof JobContactData){ 
			$this->can() && $v_data->email = $v_faker->email();
			$this->can() && $v_data->tel = $v_faker->phoneNumber();
			$this->can() && $v_data->gsm = $v_faker->e164PhoneNumber();
		}
		return array( 
			'firstname' => $this->can() ? $v_faker->firstName() :  NULL,
			'lastname' => igk_str_repeat_callback(function($i)use($v_faker){ return (($i>0)?' ':'').$v_faker->lastName();}, rand(1, 2)),
			'title' => rand(0,1)? $v_faker->title(): NULL,
			'alias' => NULL,
			'data' => is_null($v_data)?null: JSon::Encode($v_data, ['ignore_empty'=>true]) 
		);
	}
}