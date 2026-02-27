<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterprisesMapping.php
// @desc: mapping JobEnterprisesMapping
// @date: 20250225 12:11:54
namespace com\igkdev\projects\ForemJobDashboard\Database\Mapping;
use IGK\Database\Mapping\SysDbMapping;
use IGK\System\Models\ModelBase;
///<summary>mapping</summary>
/**
* mapping
* @package com\igkdev\projects\ForemJobDashboard\Database\Mapping
* @author C.A.D. BONDJE DOUE
*/
class JobEnterprisesMapping extends SysDbMapping{

    /**
    * auto generate doc.
    * @param ModelBase $model
    */
    public function map(ModelBase $model){
	    return parent::map($model);
	}
}