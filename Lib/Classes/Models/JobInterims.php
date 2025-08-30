<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobInterims.php
// @date: 20250829 15:43:00
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* job's engines
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string $url engine url
* @property string $description description
* @property string $picture interims pictures
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FD_ID() - `id` full column name 
* @method static string FD_NAME() - `name` full column name 
* @method static string FD_URL() - `url` full column name 
* @method static string FD_DESCRIPTION() - `description` full column name 
* @method static string FD_PICTURE() - `picture` full column name 
* @method static string FD_CREATE_AT() - `Create_At` full column name 
* @method static string FD_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJobInterId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJobInterId() - macros function
* @method static ?self Add(string $name, string $url, string $description, string $picture, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $url, string $description, string $picture, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobInterims extends ModelBase{
	const FD_ID="job_inter_id";
	const FD_NAME="job_inter_name";
	const FD_URL="job_inter_url";
	const FD_DESCRIPTION="job_inter_description";
	const FD_PICTURE="job_inter_picture";
	const FD_CREATE_AT="job_inter_Create_At";
	const FD_UPDATE_AT="job_inter_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_interims";
	/**
	* override primary key 
	*/
	protected $primaryKey = "job_inter_id";
	/**
	* override refid key 
	*/
	protected $refId = "job_inter_id";
}