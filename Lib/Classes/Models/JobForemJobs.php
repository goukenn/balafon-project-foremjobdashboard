<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobForemJobs.php
// @date: 20240905 04:02:30
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id
* @property string $reference
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, string $reference, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, string $reference, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobForemJobs extends ModelBase{
	const FD_ID="id";
	const FD_JOB_ID="job_id";
	const FD_REFERENCE="reference";
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
}