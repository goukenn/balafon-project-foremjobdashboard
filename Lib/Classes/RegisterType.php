<?php
// @author: C.A.D. BONDJE DOUE
// @file: RegisterType.php
// @date: 20240904 09:14:13
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;
///<summary></summary>

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
*/
abstract class RegisterType{
    use EnumeratesConstants;
    use ModelTableConstantTrait;

    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = JobRegisterTypes::class;

    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = JobRegisterTypes::FD_NAME;

    /**
    * auto generate doc.
    * @var mixed
    */
    const FAKE = 'FAKE';

    /**
    * auto generate doc.
    * @var mixed
    */
    const REAL = 'REAL';
}