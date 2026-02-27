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
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
*/
class StatusTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;

    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = JobStatusTypes::class;

    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = JobStatusTypes::FD_NAME;

    /**
    * auto generate doc.
    * @var mixed
    */
    const COMPLETE='COMPLETE';

    /**
    * auto generate doc.
    * @var mixed
    */
    const OPENED='OPENED';

    /**
    * auto generate doc.
    * @var mixed
    */
    const CLOSED='CLOSED';
}