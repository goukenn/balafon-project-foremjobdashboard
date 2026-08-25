<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobFollows.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id
* @property string $description
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_JOB_ID() - `job_id` full column name 
* @method static string FN_DESCRIPTION() - `description` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnId() - macros function
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, string $description, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, string $description, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobFollows extends ModelBase{
	const FD_ID="id";
	const FD_JOB_ID="job_id";
	const FD_DESCRIPTION="description";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_follows";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}