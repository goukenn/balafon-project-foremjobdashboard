<?php
// @author: C.A.D. BONDJE DOUE
// @file: FJDHooks.php
// @date: 20251211 18:22:25
namespace com\igkdev\projects\ForemJobDashboard;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
*/
abstract class FJDHooks{
    /**
    * auto generate doc.
    * @var mixed
    */
    const FOREM_JOB_DOC_DELETING = 'forem.job.doc.deleting';
    /**
     * filter the items of the connected user's context menu (header). "logout" is always appended last.
     * hook args: ['ctrl'=>project, 'filter'=>current items, 'user'=>connected user]
     * a handler sets `$e->output` to the new list of items: [['label'=>string, 'href'=>string, 'icon'=>?string], ...]
     */
    const FILTER_USER_CONTEXT_MENU = 'com.igkdev.sys://filter/app/user-context-menu';
}