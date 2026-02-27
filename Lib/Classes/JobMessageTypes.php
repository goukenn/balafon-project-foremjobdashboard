<?php
namespace com\igkdev\projects\ForemJobDashboard;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use com\igkdev\projects\ForemJobDashboard\Models\JobMessageTypes as JobMessageTypesModel;
use IGK\Database\ORM\Annotations as ORM;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
*/
class JobMessageTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;

    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = JobMessageTypesModel::class;

    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = JobMessageTypesModel::FD_NAME;
    /**
     * enterprise response
     */
    const RESPONSE='RESPONSE';
    /**
     * entreprise message - for tel or other broadcast
     */
    const MESSAGE='MESSAGE';
    /**
     * receive mail . mail info
     * {{ object: string ,title:string, content:content}} 
     */
    const MAIL='MAIL';
    /**
     * follow message.
     */
    const FOLLOW='FOLLOW';
    /**
     * use reply message
     */
    const REPLY = 'REPLY';
}