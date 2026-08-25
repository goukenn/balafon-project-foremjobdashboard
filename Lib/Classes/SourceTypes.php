<?php
// @author: C.A.D. BONDJE DOUE
// @file: SourceTypes.php
// @date: 20240905 04:03:45
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
* @ORM\InitData()
*/ 
class SourceTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = JobSourceTypes::class;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = JobSourceTypes::FD_NAME;
    /**
    * auto generate doc.
    * @var mixed
    */
    const WEB="WEB";
    /**
    * auto generate doc.
    * @var mixed
    */
    const NEWLETTER="NEWLETTER";
    /**
    * auto generate doc.
    * @var mixed
    */
    const SPONTANOUS="SPONTANOUS";
    /**
    * auto generate doc.
    * @var mixed
    */
    const JOBSEARCH_ENGINE="SEARCH ENGINE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const ICTJOB ="ICTJOB.BE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const MONSTER ="MONSTER.BE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const LINKEDIN ="LINKEDIN.BE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const INDEED ="INDEED.BE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const X_DOT_COM ="X.COM";
    /**
    * auto generate doc.
    * @var mixed
    */
    const FACEBOOK = "FACEBOOK.COM";
    /**
    * auto generate doc.
    * @var mixed
    */
    const FOREM ="FOREM";
    /**
    * auto generate doc.
    * @var mixed
    */
    const FRIEND = 'FRIEND';
    /**
    * auto generate doc.
    * @var mixed
    */
    const WORKFOR_DOT_BE = 'TRAVAILLERPOUR.BE';
    /**
    * auto generate doc.
    * @var mixed
    */
    const INTERIM = 'INTERIM';
    /**
    * auto generate doc.
    * @var mixed
    */
    const VINDAZO = 'VINDAZO';
    /**
    * auto generate doc.
    * @var mixed
    */
    const LUXJOB = 'LUXJOB';
    /**
    * auto generate doc.
    * @var mixed
    */
    const MAIL = 'MAIL';
}