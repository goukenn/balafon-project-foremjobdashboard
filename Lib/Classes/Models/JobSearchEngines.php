<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobSearchEngines.php
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
* @property string $picture picture
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FD_ID() - `id` full column name 
* @method static string FD_NAME() - `name` full column name 
* @method static string FD_URL() - `url` full column name 
* @method static string FD_DESCRIPTION() - `description` full column name 
* @method static string FD_PICTURE() - `picture` full column name 
* @method static string FD_CREATE_AT() - `Create_At` full column name 
* @method static string FD_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJobEngId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJobEngId() - macros function
* @method static ?self Add(string $name, string $url, string $description, string $picture, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $url, string $description, string $picture, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobSearchEngines extends ModelBase{
	const FD_ID="job_eng_id";
	const FD_NAME="job_eng_name";
	const FD_URL="job_eng_url";
	const FD_DESCRIPTION="job_eng_description";
	const FD_PICTURE="job_eng_picture";
	const FD_CREATE_AT="job_eng_Create_At";
	const FD_UPDATE_AT="job_eng_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_search_engines";
	/**
	* override primary key 
	*/
	protected $primaryKey = "job_eng_id";
	/**
	* override refid key 
	*/
	protected $refId = "job_eng_id";
}