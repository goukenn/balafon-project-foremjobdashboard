<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobMotivations.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
/**
* Job's categories
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $guid
* @property string $lang ="en-EN"
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id
* @property string $data
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_GUID() - `guid` full column name 
* @method static string FN_LANG() - `lang` full column name 
* @method static string FN_USER_ID() - `user_id` full column name 
* @method static string FN_DATA() - `data` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJmtId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJmtId() - macros function
* @method static ?self Add(string $guid, int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $data, string $lang ="en-EN", string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $guid, int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $data, string $lang ="en-EN", string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobMotivations extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="jmt_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_GUID="jmt_guid";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_LANG="jmt_lang";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_USER_ID="jmt_user_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_DATA="jmt_data";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CREATE_AT="jmt_Create_At";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_UPDATE_AT="jmt_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_motivations";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jmt_id";
	/**
	* override refid key 
	*/
	protected $refId = "jmt_id";
	/**
	*override display key
	*/
	protected $display = "jmt_guid";
}