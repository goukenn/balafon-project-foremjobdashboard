<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobExperienceDetails.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
/**
* user's experiences categories details
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobExperiences $experience_id
* @property string $value
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_EXPERIENCE_ID() - `experience_id` full column name 
* @method static string FN_VALUE() - `value` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJobExpdId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJobExpdId() - macros function
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\JobExperiences $experience_id, string $value, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\JobExperiences $experience_id, string $value, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobExperienceDetails extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="job_expd_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_EXPERIENCE_ID="job_expd_experience_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_VALUE="job_expd_value";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CREATE_AT="job_expd_Create_At";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_UPDATE_AT="job_expd_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_experience_details";
	/**
	* override primary key 
	*/
	protected $primaryKey = "job_expd_id";
	/**
	* override refid key 
	*/
	protected $refId = "job_expd_id";
}