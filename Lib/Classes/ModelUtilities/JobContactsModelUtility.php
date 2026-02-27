<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobContactsModelUtility.php
// @desc: module utility JobContactsModelUtility
// @date: 20240914 10:15:02
namespace com\igkdev\projects\ForemJobDashboard\ModelUtilities;
use com\igkdev\projects\ForemJobDashboard\Models\JobContacts;
use IGK\Database\DbQueryOptions;
use IGKDbModelUtility;
///<summary>view entry point</summary>
/**
* view entry point
* @package com\igkdev\projects\ForemJobDashboard\ModelUtilities
* @author C.A.D. BONDJE DOUE
*/
class JobContactsModelUtility extends IGKDbModelUtility{

    /**
    * auto generate doc.
    */
    public function list(){

        /**
        * auto generate doc.
        * @var IDbQueryOptions
        */
        $v_opts =  new DbQueryOptions;
        $v_opts->Columns = [
            JobContacts::column(JobContacts::FD_FIRSTNAME)=>'firstName', 
            JobContacts::column(JobContacts::FD_LASTNAME)=>'lastName',  
            JobContacts::column(JobContacts::FD_TITLE)=>'title',  
        ];
        $r = JobContacts::select_all(null, $v_opts); 
        return $r;
    }
}