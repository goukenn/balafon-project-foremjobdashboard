<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobImportInfo.php
// @date: 20250225 13:26:18
namespace com\igkdev\projects\ForemJobDashboard\Database\Import;
use IGK\System\IO\JSon\Annotations\JSonBindAsAnnotation;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Database\Import
* @author C.A.D. BONDJE DOUE
*/
class JobImportInfo{
    var $enterprise;
    var $vat;
    var $title;
    var $contact;
    var $tel;
    var $address;
    var $site;
    var $email;
    var $description;
    var $slogan;
    /**
     * array of jobs 
     * @var array[]
     * JSonBindAsAnnnotation(arrayOf<JobEntryImportInfo>)
     */
    var $jobs;
}