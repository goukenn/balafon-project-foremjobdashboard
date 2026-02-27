<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobStatusTypes.php
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
class JobStatusTypes extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="jbs_id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_NAME="jbs_name";

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
	protected $table = "%prefix%job_status_types";
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
	protected $display = "jbs_name";
}