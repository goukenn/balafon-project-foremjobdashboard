<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobStatusTypes.php
// @date: 20260910 10:46:57
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* 
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
* @method static ?array joinOnJbsId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJbsId() - macros function
* @method static ?self Add(string $name, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobStatusTypes extends ModelBase{
	const FD_ID="jbs_id";
	const FD_NAME="jbs_name";
	const FD_CREATE_AT="jbs_Create_At";
	const FD_UPDATE_AT="jbs_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_status_types";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jbs_id";
	/**
	* override refid key 
	*/
	protected $refId = "jbs_id";
	/**
	*override display key
	*/
	protected $display = "jbs_name";
}