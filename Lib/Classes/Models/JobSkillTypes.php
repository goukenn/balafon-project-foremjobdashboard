<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobSkillTypes.php
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
class JobSkillTypes extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="id";

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_NAME="name";

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
	protected $table = "%prefix%job_skill_types";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}