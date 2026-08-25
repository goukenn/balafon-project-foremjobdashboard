<?php
// @author: C.A.D. BONDJE DOUE
// @date: 20251210 16:46:57
namespace com\igkdev\projects\ForemJobDashboard;
use IGK\System\Traits\EnumeratesConstants;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
*/
abstract class EnumAuthorizations{
	use EnumeratesConstants;
    /**
    * auto generate doc.
    * @var mixed
    */
    const can_read = 'can_read';
    /**
    * auto generate doc.
    * @var mixed
    */
    const document_management = 'document_management';
    /**
    * auto generate doc.
    * @var mixed
    */
    const drop_document = 'drop_document';
    /**
    * auto generate doc.
    * @var mixed
    */
    const update_forem_reference = 'update_forem_reference';
}