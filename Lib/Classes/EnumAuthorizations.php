<?php
// @author: C.A.D. BONDJE DOUE
// @date: 20251210 16:46:57
namespace com\igkdev\projects\ForemJobDashboard;
use IGK\System\Traits\EnumeratesConstants;
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
abstract class EnumAuthorizations{
	use EnumeratesConstants;
	const can_read = 'can_read';
	const document_management = 'document_management';
	const drop_document = 'drop_document';
	const update_forem_reference = 'update_forem_reference';
}