<?php
// @author: C.A.D. BONDJE DOUE
// @file: Jobs.php
// @date: 20240905 04:02:30
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string $guid
* @property string $title
* @property int $from
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes $type
* @property int $status
* @property int $printable ="1"
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id
* @property string $description
* @property string $summary
* @property float $salary
* @property int $contract_type_id
* @property string $path
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static ?self Add(string $guid, string $title, int $from, int|\com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes $type, int $status, int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $description, string $summary, float $salary, int $contract_type_id, string $path, int $printable ="1", string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string $guid, string $title, int $from, int|\com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes $type, int $status, int|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_id, string $description, string $summary, float $salary, int $contract_type_id, string $path, int $printable ="1", string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class Jobs extends ModelBase{
	const FD_ID="id";
	const FD_GUID="guid";
	const FD_TITLE="title";
	const FD_FROM="from";
	const FD_TYPE="type";
	const FD_STATUS="status";
	const FD_PRINTABLE="printable";
	const FD_USER_ID="user_id";
	const FD_DESCRIPTION="description";
	const FD_SUMMARY="summary";
	const FD_SALARY="salary";
	const FD_CONTRACT_TYPE_ID="contract_type_id";
	const FD_PATH="path";
	const FD_CREATE_AT="Create_At";
	const FD_UPDATE_AT="Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%jobs"; 
	/**
	* override primary key 
	*/
	protected $primaryKey = "id";
	/**
	* override refid key 
	*/
	protected $refId = "id";
}