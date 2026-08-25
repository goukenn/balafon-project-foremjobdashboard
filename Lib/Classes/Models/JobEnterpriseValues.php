<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterpriseValues.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* store enterprises's known values
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseValueTypes $enterprise_value_id
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_ENTERPRISE_ID() - `enterprise_id` full column name 
* @method static string FN_ENTERPRISE_VALUE_ID() - `enterprise_value_id` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnId() - macros function
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseValueTypes $enterprise_value_id, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, int|\com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseValueTypes $enterprise_value_id, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobEnterpriseValues extends ModelBase{
	const FD_ID="id";
	const FD_ENTERPRISE_ID="enterprise_id";
	const FD_ENTERPRISE_VALUE_ID="enterprise_value_id";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_enterprise_values";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
	protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'enterprise_id',
	    1 => 'enterprise_value_id',
	  ),
	);
}