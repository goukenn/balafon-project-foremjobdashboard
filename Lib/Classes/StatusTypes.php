<?php
// @author: C.A.D. BONDJE DOUE
// @file: StatusTypes.php
// @date: 20240905 03:29:34
namespace com\igkdev\projects\ForemJobDashboard;

use com\igkdev\projects\ForemJobDashboard\Models\JobStatus;
use IGK\Models\Traits\ModelConstantsHelper;
use IGK\System\Traits\EnumeratesConstants;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
class StatusTypes{
    use EnumeratesConstants;
    use ModelConstantsHelper;
    protected static $model = JobStatus::class;
    protected static $field_name = JobStatus::FD_NAME;

    const COMPLETE='COMPLETE';
    const OPENED='OPENED';
    const CLOSED='CLOSED';
}