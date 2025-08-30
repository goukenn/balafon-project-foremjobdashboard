<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEntryImportInfo.php
// @date: 20250225 14:41:16
namespace com\igkdev\projects\ForemJobDashboard\Database\Import;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Database\Import
* @author C.A.D. BONDJE DOUE
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
     * 
     * @var mixed
     */
    var $date;
    var $title;
    var $reference;
    var $type;
    var $contractType;
    var $foremReference;
    var $location;
    var $cv;
    var $motivation;
    var $documents;
    /**
     * list of response 
     * @var null|string[]|string 
     */
    var $responses;
    var $description;
    var $summary;
    var $path;
    var $printable;
    var $salary;
}