<?php
// @author: C.A.D. BONDJE DOUE
// @file: SkillTypes.php
// @date: 20240905 03:46:08
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobSkills;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
*/
class SkillTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = JobSkills::class;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = JobSkills::FD_NAME;
    /**
    * auto generate doc.
    * @var mixed
    */
    const DEVELOPER = 'DEVELOPER';
    /**
    * auto generate doc.
    * @var mixed
    */
    const ANALYST = 'ANALYST';
}