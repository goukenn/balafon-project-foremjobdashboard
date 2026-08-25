<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobCategories.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* Job's categories
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string $short_name
* @property string $description
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_NAME() - `name` full column name 
* @method static string FN_SHORT_NAME() - `short_name` full column name 
* @method static string FN_DESCRIPTION() - `description` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJctId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJctId() - macros function
* @method static ?self Add(string $name, string $short_name, string $description, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $short_name, string $description, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobCategories extends ModelBase{
	const FD_ID="jct_id";
	const FD_NAME="jct_name";
	const FD_SHORT_NAME="jct_short_name";
	const FD_DESCRIPTION="jct_description";
	const FD_CREATE_AT="jct_Create_At";
	const FD_UPDATE_AT="jct_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_categories";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jct_id";
	/**
	* override refid key 
	*/
	protected $refId = "jct_id";
	/**
	*override display key
	*/
	protected $display = "jct_name";
}