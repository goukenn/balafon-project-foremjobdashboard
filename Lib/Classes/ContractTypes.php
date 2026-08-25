<?php
// @author: C.A.D. BONDJE DOUE
// @file: ContractTypes.php
// @date: 20240905 03:38:24
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobContractTypes;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;

 
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @ORM\InitData()
*/
abstract class ContractTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = JobContractTypes::class;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = JobContractTypes::FD_NAME;
    /**
    * auto generate doc.
    * @var mixed
    */
    const EMPOYEE = 'EMPLOYEE';
    /**
    * auto generate doc.
    * @var mixed
    */
    const WORKER = 'WORKER';
    /**
    * auto generate doc.
    * @var mixed
    */
    const EMPOYEE_HALF = 'EMPLOYEE-HALF';
    /**
    * auto generate doc.
    * @var mixed
    */
    const WORKER_HALF = 'WORKER-HALF';
    /**
    * auto generate doc.
    * @var mixed
    */
    const UNKNOW = 'UNKNOW';
}