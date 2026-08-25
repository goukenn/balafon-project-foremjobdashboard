<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseCategoriesEnum.php
// @date: 20250822 09:42:10
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseCategories;
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
class EnterpriseCategoriesEnum
{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = JobEnterpriseCategories::class;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = JobEnterpriseCategories::FD_NAME;
    /**
    * auto generate doc.
    * @var mixed
    */
    const INTERIM = 'INTERIM';
    /**
    * auto generate doc.
    * @var mixed
    */
    const IT_AGENCY = 'IT AGENCY';
}