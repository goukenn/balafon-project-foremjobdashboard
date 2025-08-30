<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobContacts.php
// @date: 20250829 15:43:00
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $firstname
* @property string $lastname
* @property string $title
* @property string $alias
* @property string $data
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FD_ID() - `id` full column name 
* @method static string FD_FIRSTNAME() - `firstname` full column name 
* @method static string FD_LASTNAME() - `lastname` full column name 
* @method static string FD_TITLE() - `title` full column name 
* @method static string FD_ALIAS() - `alias` full column name 
* @method static string FD_DATA() - `data` full column name 
* @method static string FD_CREATE_AT() - `Create_At` full column name 
* @method static string FD_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnId() - macros function
* @method static ?self Add(string $firstname, string $lastname, string $title, string $alias, string $data, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $firstname, string $lastname, string $title, string $alias, string $data, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* @method static void list() macros function
* */
class JobContacts extends ModelBase{
	const FD_ID="id";
	const FD_FIRSTNAME="firstname";
	const FD_LASTNAME="lastname";
	const FD_TITLE="title";
	const FD_ALIAS="alias";
	const FD_DATA="data";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_contacts";
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}