<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUserSettings.php
// @date: 20260910 10:46:57
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* user's settings
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id
* @property string $name
* @property string $value
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_USER_ID() - `user_id` full column name 
* @method static string FN_NAME() - `name` full column name 
* @method static string FN_VALUE() - `value` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJobUssId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJobUssId() - macros function
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $name, string $value, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $name, string $value, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobUserSettings extends ModelBase{
	const FD_ID="job_uss_id";
	const FD_USER_ID="job_uss_user_id";
	const FD_NAME="job_uss_name";
	const FD_VALUE="job_uss_value";
	const FD_CREATE_AT="job_uss_Create_At";
	const FD_UPDATE_AT="job_uss_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_user_settings";
	/**
	* override primary key 
	*/
	protected $primaryKey = "job_uss_id";
	/**
	* override refid key 
	*/
	protected $refId = "job_uss_id";
	protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'job_uss_user_id',
	    1 => 'job_uss_name',
	  ),
	);
}