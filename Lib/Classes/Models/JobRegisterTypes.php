<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobRegisterTypes.php
// @date: 20240905 04:02:30
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string $description
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static ?self Add(string $name, string $description, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $description, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobRegisterTypes extends ModelBase{
	const FD_ID="id";
	const FD_NAME="name";
	const FD_DESCRIPTION="description";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_register_types"; 
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}