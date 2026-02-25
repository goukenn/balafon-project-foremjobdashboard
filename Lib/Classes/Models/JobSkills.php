<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobSkills.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
/**
* available skills
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string $description
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobSkillTypes $skill_type_id
* @property int $rate indicate this skill is subject to rate rule
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_NAME() - `name` full column name 
* @method static string FN_DESCRIPTION() - `description` full column name 
* @method static string FN_SKILL_TYPE_ID() - `skill_type_id` full column name 
* @method static string FN_RATE() - `rate` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnId() - macros function
* @method static ?self Add(string $name, string $description, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobSkillTypes $skill_type_id, int $rate, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $description, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobSkillTypes $skill_type_id, int $rate, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobSkills extends ModelBase{
	const FD_ID="id";
	const FD_NAME="name";
	const FD_DESCRIPTION="description";
	const FD_SKILL_TYPE_ID="skill_type_id";
	const FD_RATE="rate";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_skills";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}