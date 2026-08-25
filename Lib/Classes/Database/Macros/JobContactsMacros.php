<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobContacts.phtml
// @desc: macros for model JobContacts
// @date: 20240914 10:26:26
namespace com\igkdev\projects\ForemJobDashboard\Database\Macros;
use com\igkdev\projects\ForemJobDashboard\Models\JobContacts;
use com\igkdev\projects\ForemJobDashboard\ModelUtilities\JobContactsModelUtility;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database\Macros
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database\Macros
*/
abstract class JobContactsMacros{
    /**
    * auto generate doc.
    * @param JobContacts $model
    */
    public static function list(JobContacts $model){
        return $model->utility()->list();  
    }
}