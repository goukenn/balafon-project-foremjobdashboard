<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterprises.php
// @date: 20260910 10:46:57
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* store enterprises
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $name
* @property string $vat
* @property string $title denomination
* @property string $description
* @property string $info store enterprise's extra info
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_NAME() - `name` full column name 
* @method static string FN_VAT() - `vat` full column name 
* @method static string FN_TITLE() - `title` full column name 
* @method static string FN_DESCRIPTION() - `description` full column name 
* @method static string FN_INFO() - `info` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnId() - macros function
* @method static ?self Add(string $name, string $vat, string $title, string $description, string $info, string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $name, string $vat, string $title, string $description, string $info, string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobEnterprises extends ModelBase{
	const FD_ID="id";
	const FD_NAME="name";
	const FD_VAT="vat";
	const FD_TITLE="title";
	const FD_DESCRIPTION="description";
	const FD_INFO="info";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_enterprises";
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
	protected $display = "name";
	protected $unique_columns = array (
	  0 => 
	  array (
	    0 => 'name',
	    1 => 'vat',
	  ),
	);
}