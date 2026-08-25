<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobDocs.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* Job's document
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id job's reference id.
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes $job_doc_type_id document's type id.
* @property string $value json data that represent a document info.
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_JOB_ID() - `job_id` full column name 
* @method static string FN_JOB_DOC_TYPE_ID() - `job_doc_type_id` full column name 
* @method static string FN_VALUE() - `value` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJdvId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJdvId() - macros function
* @method static ?self Add(int|?\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes $job_doc_type_id, string $value, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|?\com\igkdev\projects\ForemJobDashboard\Models\Jobs $job_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes $job_doc_type_id, string $value, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* @method static bool isOwnedBy($user) macros function definition 
* @method static bool isUserFileDocument($user) macros function definition 
* @method static string typeName() macros function definition
* */
class JobDocs extends ModelBase{
	const FD_ID="jdv_id";
	const FD_JOB_ID="jdv_job_id";
	const FD_JOB_DOC_TYPE_ID="jdv_job_doc_type_id";
	const FD_VALUE="jdv_value";
	const FD_CREATE_AT="jdv_Create_At";
	const FD_UPDATE_AT="jdv_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_docs";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jdv_id";
	/**
	* override refid key 
	*/
	protected $refId = "jdv_id";
}