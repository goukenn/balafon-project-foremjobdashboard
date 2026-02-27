<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterprisesContacts.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
/**
* Job Enterprise's contact list
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobContacts $contact_id
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id
* @property string $occupation contact occupation
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_CONTACT_ID() - `contact_id` full column name 
* @method static string FN_ENTERPRISE_ID() - `enterprise_id` full column name 
* @method static string FN_OCCUPATION() - `occupation` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnId() - macros function
* @method static ?self Add(int|?\com\igkdev\projects\ForemJobDashboard\Models\JobContacts $contact_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, string $occupation, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|?\com\igkdev\projects\ForemJobDashboard\Models\JobContacts $contact_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises $enterprise_id, string $occupation, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobEnterprisesContacts extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CONTACT_ID="contact_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ENTERPRISE_ID="enterprise_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_OCCUPATION="occupation";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CREATE_AT="Create_At";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_enterprises_contacts";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";

    /**
    * auto generate doc.
    * @var mixed
    */
    protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'contact_id',
	    1 => 'enterprise_id',
	  ),
	);
}