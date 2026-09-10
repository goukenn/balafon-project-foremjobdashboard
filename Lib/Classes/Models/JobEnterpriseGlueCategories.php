<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterpriseGlueCategories.php
// @date: 20260910 10:46:57
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* enterprise list of categories
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseCategories $enterprise_cat_id
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_ENTERPRISE_ID() - `enterprise_id` full column name 
* @method static string FN_ENTERPRISE_CAT_ID() - `enterprise_cat_id` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJobEcId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJobEcId() - macros function
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseCategories $enterprise_cat_id, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseCategories $enterprise_cat_id, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobEnterpriseGlueCategories extends ModelBase{
	const FD_ID="job_ec_id";
	const FD_ENTERPRISE_ID="job_ec_enterprise_id";
	const FD_ENTERPRISE_CAT_ID="job_ec_enterprise_cat_id";
	const FD_CREATE_AT="job_ec_Create_At";
	const FD_UPDATE_AT="job_ec_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_enterprise_glue_categories";
	/**
	* override primary key 
	*/
	protected $primaryKey = "job_ec_id";
	/**
	* override refid key 
	*/
	protected $refId = "job_ec_id";
	protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'job_ec_enterprise_id',
	    1 => 'job_ec_enterprise_cat_id',
	  ),
	);
}