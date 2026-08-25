<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobMessageTypes.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* Job's message types
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_NAME() - `name` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJmstId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJmstId() - macros function
* @method static ?self Add(string $name, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobMessageTypes extends ModelBase{
	const FD_ID="jmst_id";
	const FD_NAME="jmst_name";
	const FD_CREATE_AT="jmst_Create_At";
	const FD_UPDATE_AT="jmst_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_message_types";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jmst_id";
	/**
	* override refid key 
	*/
	protected $refId = "jmst_id";
	/**
	*override display key
	*/
	protected $display = "jmst_name";
}