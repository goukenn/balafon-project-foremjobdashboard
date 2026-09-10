<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUsers.php
// @date: 20260910 10:46:57
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* register a system user to project
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string|\IGK\Models\Users $guid
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_GUID() - `guid` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJbuId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJbuId() - macros function
* @method static ?self Add(string|\IGK\Models\Users $guid, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string|\IGK\Models\Users $guid, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobUsers extends ModelBase{
	const FD_ID="jbu_id";
	const FD_GUID="jbu_guid";
	const FD_CREATE_AT="jbu_Create_At";
	const FD_UPDATE_AT="jbu_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_users";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jbu_id";
	/**
	* override refid key 
	*/
	protected $refId = "jbu_id";
	/**
	*override display key
	*/
	protected $display = "jbu_guid";
}