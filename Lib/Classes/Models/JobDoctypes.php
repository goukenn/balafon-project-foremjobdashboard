<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobDoctypes.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
/**
* Job's type of extra document
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_NAME() - `name` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJdtId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJdtId() - macros function
* @method static ?self Add(string $name, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobDoctypes extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="jdt_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_NAME="jdt_name";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CREATE_AT="jdt_Create_At";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_UPDATE_AT="jdt_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_doctypes";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jdt_id";
	/**
	* override refid key 
	*/
	protected $refId = "jdt_id";
	/**
	*override display key
	*/
	protected $display = "jdt_name";
}