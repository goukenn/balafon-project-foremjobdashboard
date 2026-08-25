<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobExperiences.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* user's experiences categories
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $title
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_TITLE() - `title` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJobExpId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJobExpId() - macros function
* @method static ?self Add(string $title, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $title, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobExperiences extends ModelBase{
	const FD_ID="job_exp_id";
	const FD_TITLE="job_exp_title";
	const FD_CREATE_AT="job_exp_Create_At";
	const FD_UPDATE_AT="job_exp_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_experiences";
	/**
	* override primary key 
	*/
	protected $primaryKey = "job_exp_id";
	/**
	* override refid key 
	*/
	protected $refId = "job_exp_id";
}