<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobImportInfo.php
// @date: 20250225 13:26:18
namespace com\igkdev\projects\ForemJobDashboard\Database\Import;
use IGK\System\IO\JSon\Annotations\JSonBindAsAnnotation;
///<summary></summary>

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database\Import
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\Database\Import
*/
class JobImportInfo{

    /**
    * auto generate doc.
    * @var mixed
    */
    var $enterprise;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $vat;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $title;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $contact;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $tel;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $address;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $site;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $email;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $description;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $slogan;
    /**
     * array of jobs 
     * @var array[]
     * JSonBindAsAnnnotation(arrayOf<JobEntryImportInfo>)
     */
    var $jobs;
}