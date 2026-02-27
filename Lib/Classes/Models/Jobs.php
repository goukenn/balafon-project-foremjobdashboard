<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Models
*/
class Jobs extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="jbs_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_GUID="jbs_guid";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_TITLE="jbs_title";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_FROM_ID="jbs_from_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CONTRACT_ID="jbs_contract_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_TREATED="jbs_treated";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CATEGORY_ID="jbs_category_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_TYPE_ID="jbs_type_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_STATUS_ID="jbs_status_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ENTERPRISE_ID="jbs_enterprise_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CONTACT_ID="jbs_contact_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_PRINTABLE="jbs_printable";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_USER_ID="jbs_user_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_DESCRIPTION="jbs_description";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_FOLLOW="jbs_follow";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_SUMMARY="jbs_summary";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_SALARY="jbs_salary";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_PATH="jbs_path";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CREATE_AT="jbs_Create_At";

    /**
    * auto generate doc.
    * @var mixed
    */
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

    /**
    * auto generate doc.
    * @var mixed
    */
    protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'jbs_contact_id',
	  ),
	);
}