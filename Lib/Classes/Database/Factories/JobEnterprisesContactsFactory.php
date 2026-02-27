<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterprisesContactsFactory.php
// @desc: factory JobEnterprisesContactsFactory
// @date: 20240914 08:33:33
namespace com\igkdev\projects\ForemJobDashboard\Database\Factories;
use IGK\System\Database\Factories\FactoryBase;
///<summary>factory</summary>
/**
* factory expected data to be and array of entreprises and contacts
* @package com\igkdev\projects\ForemJobDashboard\Database\Factories
* @author C.A.D. BONDJE DOUE
*/
class JobEnterprisesContactsFactory extends FactoryBase{

    /**
    * auto generate doc.
    * @return ?array
    */
    public function definition(): ?array{
		if (!$this->data || (count($this->data)<2)){
			return null;
		}
		list($enterprises, $contacts) = $this->data;
		return array (
		'enterprise_id' => $enterprises[rand(0, count($enterprises)-1)]->id,
		'contact_id' => $contacts[rand(0, count($contacts)-1)]->id, 
		);
	}
}