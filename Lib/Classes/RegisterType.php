<?php
// @author: C.A.D. BONDJE DOUE
// @file: RegisterType.php
// @date: 20240904 09:14:13
namespace com\igkdev\projects\ForemJobDashboard;

use com\igkdev\projects\ForemJobDashboard\Models\JobRegisterTypes;
use IGK\Models\Traits\ModelConstantsHelper;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
* @ORM\InitDataAnnotation()
*/
abstract class RegisterType{
    use EnumeratesConstants;
    use ModelConstantsHelper;
    protected static $model = JobRegisterTypes::class;
    protected static $field_name = JobRegisterTypes::FD_NAME;
    const FAKE = 'FAKE';
    const REAL = 'REAL';
}