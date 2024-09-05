<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUsers.php
// @date: 20240905 04:02:30
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string|\IGK\Models\Users $guid
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static ?self Add(string|\IGK\Models\Users $guid, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string|\IGK\Models\Users $guid, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobUsers extends ModelBase{
	const FD_ID="id";
	const FD_GUID="guid";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_users"; 
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}