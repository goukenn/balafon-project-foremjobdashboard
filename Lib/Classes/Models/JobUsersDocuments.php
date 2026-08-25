<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUsersDocuments.php
// @date: 20260824 18:09:05
namespace com\igkdev\projects\ForemJobDashboard\Models;


use com\igkdev\projects\ForemJobDashboard\Models\ModelBase;

/**
* store user's documents
* @package com\igkdev\projects\ForemJobDashboard\Models
* @author C.A.D. BONDJE DOUE
* @property int $id
* @property string|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_guid
* @property string $type ="MOTIVATION"
* @property string $content description
* @property string $title content title
* @property string $slug
* @property string $description description
* @property string $Create_At ="Now()"
* @property string $Update_At ="Now()"
* @method static string FN_ID() - `id` full column name 
* @method static string FN_USER_GUID() - `user_guid` full column name 
* @method static string FN_TYPE() - `type` full column name 
* @method static string FN_CONTENT() - `content` full column name 
* @method static string FN_TITLE() - `title` full column name 
* @method static string FN_SLUG() - `slug` full column name 
* @method static string FN_DESCRIPTION() - `description` full column name 
* @method static string FN_CREATE_AT() - `Create_At` full column name 
* @method static string FN_UPDATE_AT() - `Update_At` full column name 
* @method static ?array joinOnJobUdocsId($call=null, ?string $type=null, string $op=\IGK\System\Database\JoinTableOp::EQUAL) - macros function 
* @method static ?string targetOnJobUdocsId() - macros function
* @method static ?self Add(string|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_guid, string $content, string $title, string $slug, string $description, string $type ="MOTIVATION", string $Create_At ="Now()", string $Update_At ="Now()") add entry helper
* @method static ?self AddIfNotExists(string|\com\igkdev\projects\ForemJobDashboard\Models\JobUsers $user_guid, string $content, string $title, string $slug, string $description, string $type ="MOTIVATION", string $Create_At ="Now()", string $Update_At ="Now()") add entry if not exists. check for unique column.
* */
class JobUsersDocuments extends ModelBase{
	const FD_ID="job_udocs_id";
	const FD_USER_GUID="job_udocs_user_guid";
	const FD_TYPE="job_udocs_type";
	const FD_CONTENT="job_udocs_content";
	const FD_TITLE="job_udocs_title";
	const FD_SLUG="job_udocs_slug";
	const FD_DESCRIPTION="job_udocs_description";
	const FD_CREATE_AT="job_udocs_Create_At";
	const FD_UPDATE_AT="job_udocs_Update_At";
	/**
	* table's name
	*/
	protected $table = "%prefix%job_users_documents";
	/**
	* override primary key 
	*/
	protected $primaryKey = "job_udocs_id";
	/**
	* override refid key 
	*/
	protected $refId = "job_udocs_id";
}