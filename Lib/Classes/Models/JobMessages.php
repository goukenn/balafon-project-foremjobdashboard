<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobMessages.php
// @date: 20251112 14:38:45
namespace com\igkdev\projects\ForemJobDashboard\Models;
use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;
/**
* Job's messages
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $offer_id
* @property int|?\com\igkdev\projects\ForemJobDashboard\Models\JobMessageTypes $message_type_id
* @property string $content
* @property string|datetime $Create_At ="Now()"
* @property string|datetime $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_OFFER_ID() - `offer_id` full column name 
* @method static string FN_MESSAGE_TYPE_ID() - `message_type_id` full column name 
* @method static string FN_CONTENT() - `content` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJmsId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJmsId() - macros function
* @method static ?self Add(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $offer_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobMessageTypes $message_type_id, string $content, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(int|\com\igkdev\projects\ForemJobDashboard\Models\Jobs $offer_id, int|?\com\igkdev\projects\ForemJobDashboard\Models\JobMessageTypes $message_type_id, string $content, string|datetime $Create_At ="Now()", string|datetime $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobMessages extends ModelBase{
	const FD_ID="jms_id";
	const FD_OFFER_ID="jms_offer_id";
	const FD_MESSAGE_TYPE_ID="jms_message_type_id";
	const FD_CONTENT="jms_content";
	const FD_CREATE_AT="jms_Create_At";
	const FD_UPDATE_AT="jms_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_messages";
	/**
	* override primary key 
	*/
	protected $primaryKey = "jms_id";
	/**
	* override refid key 
	*/
	protected $refId = "jms_id";
}