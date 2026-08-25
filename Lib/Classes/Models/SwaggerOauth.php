<?php
// @author: C.A.D. BONDJE DOUE
// @file: SwaggerOauth.php
// @date: 20250203 00:59:41
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
class SwaggerOauth extends ModelBase{
    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="id";
    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_CLIENT_ID="client_id";
    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_USER_ID="user_id";
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
	protected $table = "%sysprefix%swagger_oauth";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
	/**
	*override display key
	*/
	protected $display = "client_id";
}