<?php
// @author: C.A.D. BONDJE DOUE
// @file: StatusTypes.php
// @date: 20240905 03:29:34
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobStatusTypes;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
* @ORM\InitDataAnnotation()
*/
class StatusTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    protected static $model = JobStatusTypes::class;
    protected static $field_name = JobStatusTypes::FD_NAME;
    const COMPLETE='COMPLETE';
    const OPENED='OPENED';
    const CLOSED='CLOSED';
}