<?php
// @author: C.A.D. BONDJE DOUE
// @file: SourceTypes.php
// @date: 20240905 04:03:45
namespace com\igkdev\projects\ForemJobDashboard;

use IGK\Models\Traits\ModelConstantsHelper;
use IGK\System\Traits\EnumeratesConstants;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
class SourceTypes{
    use EnumeratesConstants;
    use ModelConstantsHelper;

    protected static $model = JobSourceTypes::class;
    protected static $field_name = JobSourceTypes::FD_NAME;

    const WEB="WEB";
    const NEWLETTER="NEWLETTER";
    const SPONTANOUS="SPONTANOUS";
}