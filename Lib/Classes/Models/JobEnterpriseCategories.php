<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterpriseCategories.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
/**
* Job's enterprise categories
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string $description
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_NAME() - `name` full column name 
* @method static string FN_DESCRIPTION() - `description` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJecId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJecId() - macros function
* @method static ?self Add(string $name, string $description, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $description, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobEnterpriseCategories extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="jec_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_NAME="jec_name";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_DESCRIPTION="jec_description";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CREATE_AT="jec_Create_At";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_UPDATE_AT="jec_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_enterprise_categories";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jec_id";
	/**
	* override refid key 
	*/
	protected $refId = "jec_id";
	/**
	*override display key
	*/
	protected $display = "jec_name";
}