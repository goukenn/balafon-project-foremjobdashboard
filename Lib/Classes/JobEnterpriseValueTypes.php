<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobEnterpriseValueTypes.php
// @date: 20260313 07:40:43
namespace com\igkdev\projects\ForemJobDashboard;
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
class JobEnterpriseValueTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    protected static $model = \com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseValueTypes::class;
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    protected static $field_name = \com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseValueTypes::FD_NAME;
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    const Integrity = 'Integrity';
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    const Honesty = 'Honesty';
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    const Accountability = 'Accountability';
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    const Innovation = 'Innovation';
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    const Teamwork = 'Teamwork';
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    const Commitment = 'Commitment';
    /**
    * auto generate doc.
    * @var mixed
    * @return
    */
    const CustomerCentricity = 'Customer Centricity';
}