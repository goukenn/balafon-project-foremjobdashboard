<?php
// @author: C.A.D. BONDJE DOUE
// @file: Sectors.php
// @date: 20240905 03:52:54
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
///<summary></summary>

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Models
*/
class Sectors extends ModelBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    const FD_ID="id";

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
	protected $table = "%prefix%sectors"; 
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}