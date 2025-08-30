<?php
// @author: C.A.D. BONDJE DOUE
// @file: SkillTypes.php
// @date: 20240905 03:46:08
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobSkills;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
* @IGK\Database\ORM\Annotations\InitDataAnnoation();
*/
class SkillTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    protected static $model = JobSkills::class;
    protected static $field_name = JobSkills::FD_NAME;
    const DEVELOPER = 'DEVELOPER';
    const ANALYST = 'ANALYST';
}