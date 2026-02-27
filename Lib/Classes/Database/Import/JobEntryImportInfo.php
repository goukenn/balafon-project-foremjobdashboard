<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEntryImportInfo.php
// @date: 20250225 14:41:16
namespace com\igkdev\projects\ForemJobDashboard\Database\Import;
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
class JobEntryImportInfo{
    /**
     * source of this job offer 
     * @var mixed
     */
    var $from;
    /**
     * user that this job binding to - login
     * @var ?string 
     */
    var $for;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $date;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $title;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $reference;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $type;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $contractType;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $foremReference;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $location;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $cv;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $motivation;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $documents;
    /**
     * list of response 
     * @var null|string[]|string 
     */
    var $responses;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $description;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $summary;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $path;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $printable;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $salary;
}