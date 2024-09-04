<?php
// @author: C.A.D. BONDJE DOUE
// @file: InitDbSchemaBuilder.php
// @date: 20240904 08:59:56
namespace com\igkdev\projects\ForemJobDashboard\Database;

use IGK\Database\SchemaBuilder\IDiagramBuilder;
use IGK\Database\SchemaBuilder\IDiagramSchemaBuilder;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Database
* @author C.A.D. BONDJE DOUE
*/
class InitDbSchemaBuilder implements IDiagramBuilder{
	/**
	* update database 
	*/
	public function upgrade(IDiagramSchemaBuilder $builder){
	    // $builder->entity(...)
	}
	/** 
	* downgrade database -  
	*/
	function downgrade(IDiagramSchemaBuilder $builder){
	    // $builder->entity(...);
	}
}