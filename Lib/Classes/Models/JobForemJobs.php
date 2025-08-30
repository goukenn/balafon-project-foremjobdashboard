<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobForemJobs.php
// @date: 20250829 15:43:00
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id
* @property string $reference
* @property string $description
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FD_ID() - `id` full column name 
* @method static string FD_JOB_ID() - `job_id` full column name 
* @method static string FD_REFERENCE() - `reference` full column name 
* @method static string FD_DESCRIPTION() - `description` full column name 
* @method static string FD_CREATE_AT() - `Create_At` full column name 
* @method static string FD_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnId() - macros function
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, string $reference, string $description, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, string $reference, string $description, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobForemJobs extends ModelBase{
	const FD_ID="id";
	const FD_JOB_ID="job_id";
	const FD_REFERENCE="reference";
	const FD_DESCRIPTION="description";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_forem_jobs";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
	/**
	*override display key
	*/
	protected $display = "job_id";
	protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'job_id',
	    1 => 'reference',
	  ),
	);
}