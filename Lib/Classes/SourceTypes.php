<?php
// @author: C.A.D. BONDJE DOUE
// @file: SourceTypes.php
// @date: 20240905 04:03:45
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
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
class SourceTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    protected static $model = JobSourceTypes::class;
    protected static $field_name = JobSourceTypes::FD_NAME;
    const WEB="WEB";
    const NEWLETTER="NEWLETTER";
    const SPONTANOUS="SPONTANOUS";
    const JOBSEARCH_ENGINE="SEARCH ENGINE";
    const ICTJOB ="ICTJOB.BE";
    const MONSTER ="MONSTER.BE";
    const LINKEDIN ="LINKEDIN.BE";
    const INDEED ="INDEED.BE";
    const X_DOT_COM ="X.COM";
    const FACEBOOK = "FACEBOOK.COM";
    const FOREM ="FOREM";
    const FRIEND = 'FRIEND';
    const WORKFOR_DOT_BE = 'TRAVAILLERPOUR.BE';
    const INTERIM = 'INTERIM';
    const VINDAZO = 'VINDAZO';
    const LUXJOB = 'LUXJOB';
    const MAIL = 'MAIL';
}