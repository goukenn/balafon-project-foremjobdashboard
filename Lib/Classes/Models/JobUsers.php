<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUsers.php
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
class JobUsers extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="jbu_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_GUID="jbu_guid";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CREATE_AT="jbu_Create_At";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_UPDATE_AT="jbu_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_users";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jbu_id";
	/**
	* override refid key 
	*/
	protected $refId = "jbu_id";
	/**
	*override display key
	*/
	protected $display = "jbu_guid";
}