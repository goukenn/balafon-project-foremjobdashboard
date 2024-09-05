<?php
// @author: C.A.D. BONDJE DOUE
// @file: SkillTypes.php
// @date: 20240905 03:46:08
namespace com\igkdev\projects\ForemJobDashboard;

use IGK\Models\Traits\ModelConstantsHelper;
use IGK\System\Traits\EnumeratesConstants;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
class SkillTypes{
    use EnumeratesConstants;
    use ModelConstantsHelper;

    protected static $model = JobSkills::class;
    protected static $field_name = JobSkills::FD_NAME;

}