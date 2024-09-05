<?php
// @author: C.A.D. BONDJE DOUE
// @file: ContractTypes.php
// @date: 20240905 03:38:24
namespace com\igkdev\projects\ForemJobDashboard;

use IGK\Models\Traits\ModelConstantsHelper;
use IGK\System\Traits\EnumeratesConstants;

///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
abstract class ContractTypes{
    use EnumeratesConstants;
    use ModelConstantsHelper;

    protected static $model = JobContractTypes::class;
    protected static $field_name = JobContractTypes::FD_NAME;

    const EMPOYEE = 'EMPLOYEE';
    const WORKER = 'WORKER';
    const EMPOYEE_HALF = 'EMPLOYEE-HALF';
    const WORKER_HALF = 'WORKER-HALF';
}