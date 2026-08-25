<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $guid
* @property string $title the title
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes $from_id origin of this job.
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobContractTypes $contract_id type of contract
* @property int $treated fake properties need to treat
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobCategories $category_id category to the job
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes $type_id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes $status_id
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobContacts $contact_id
* @property int $printable ="1"
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id
* @property string $description global job description
* @property string $follow date to flow. example: +1 week
* @property string $summary honda
* @property float $salary
* @property string $path path indication
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_GUID() - `guid` full column name 
* @method static string FN_TITLE() - `title` full column name 
* @method static string FN_FROM_ID() - `from_id` full column name 
* @method static string FN_CONTRACT_ID() - `contract_id` full column name 
* @method static string FN_TREATED() - `treated` full column name 
* @method static string FN_CATEGORY_ID() - `category_id` full column name 
* @method static string FN_TYPE_ID() - `type_id` full column name 
* @method static string FN_STATUS_ID() - `status_id` full column name 
* @method static string FN_ENTERPRISE_ID() - `enterprise_id` full column name 
* @method static string FN_CONTACT_ID() - `contact_id` full column name 
* @method static string FN_PRINTABLE() - `printable` full column name 
* @method static string FN_USER_ID() - `user_id` full column name 
* @method static string FN_DESCRIPTION() - `description` full column name 
* @method static string FN_FOLLOW() - `follow` full column name 
* @method static string FN_SUMMARY() - `summary` full column name 
* @method static string FN_SALARY() - `salary` full column name 
* @method static string FN_PATH() - `path` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJbsId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJbsId() - macros function
* @method static ?self Add(string $guid, string $title, int|\com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes $from_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobContractTypes $contract_id, int $treated, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobCategories $category_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes $type_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes $status_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobContacts $contact_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $description, string $follow, string $summary, float $salary, string $path, int $printable ="1", string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $guid, string $title, int|\com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes $from_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobContractTypes $contract_id, int $treated, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobCategories $category_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes $type_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes $status_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobContacts $contact_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $description, string $follow, string $summary, float $salary, string $path, int $printable ="1", string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* @method static mixed attachForemReference($ref_id) macros function definition 
* @method static ?string foremReference() macros function definition
* */
class Jobs extends ModelBase{
	const FD_ID="jbs_id";
	const FD_GUID="jbs_guid";
	const FD_TITLE="jbs_title";
	const FD_FROM_ID="jbs_from_id";
	const FD_CONTRACT_ID="jbs_contract_id";
	const FD_TREATED="jbs_treated";
	const FD_CATEGORY_ID="jbs_category_id";
	const FD_TYPE_ID="jbs_type_id";
	const FD_STATUS_ID="jbs_status_id";
	const FD_ENTERPRISE_ID="jbs_enterprise_id";
	const FD_CONTACT_ID="jbs_contact_id";
	const FD_PRINTABLE="jbs_printable";
	const FD_USER_ID="jbs_user_id";
	const FD_DESCRIPTION="jbs_description";
	const FD_FOLLOW="jbs_follow";
	const FD_SUMMARY="jbs_summary";
	const FD_SALARY="jbs_salary";
	const FD_PATH="jbs_path";
	const FD_CREATE_AT="jbs_Create_At";
	const FD_UPDATE_AT="jbs_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%jobs";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jbs_id";
	/**
	* override refid key 
	*/
	protected $refId = "jbs_id";
	/**
	*override display key
	*/
	protected $display = "jbs_guid";
	protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'jbs_contact_id',
	  ),
	);
}