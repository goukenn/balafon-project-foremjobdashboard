<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseCategoriesEnum.php
// @date: 20250822 09:42:10
namespace com\igkdev\projects\ForemJobDashboard;

use com\igkdev\projects\ForemJobDashboard\Models\JobEnterpriseCategories;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;

/**
 * 
 * @package com\igkdev\projects\ForemJobDashboard
 * @author C.A.D. BONDJE DOUE
 */
class EnterpriseCategoriesEnum
{
    use EnumeratesConstants;
    use ModelTableConstantTrait;


    protected static $model = JobEnterpriseCategories::class;
    protected static $field_name = JobEnterpriseCategories::FD_NAME;


    const INTERIM = 'INTERIM';
    const IT_AGENCY = 'IT AGENCY';
}
