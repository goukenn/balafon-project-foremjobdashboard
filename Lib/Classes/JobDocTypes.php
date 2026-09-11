<?php
// @author: C.A.D. BONDJE DOUE
// @file: SourceTypes.php
// @date: 20240905 04:03:45
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes as ModelDockTypes;
use IGK\Models\Traits\ModelTableConstantTrait;
use IGK\System\Traits\EnumeratesConstants;
use IGK\Database\ORM\Annotations as ORM;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
* @ORM\InitData()
*/ 
class JobDocTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $model = ModelDockTypes::class;
    /**
    * auto generate doc.
    * @var mixed
    */
    protected static $field_name = ModelDockTypes::FD_NAME;
    /**
    * auto generate doc.
    * @var mixed
    */
    const DOCUMENT="DOC";
    /**
    * auto generate doc.
    * @var mixed
    */
    const MESSAGE="MESSAGE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const RESPONSE="RESPONSE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const INFO="INFO";
    /**
    * auto generate doc.
    * @var mixed
    */
    const FILE="FILE";
    /**
    * auto generate doc.
    * @var mixed
    */
    const REMARK="REMARK";
    /**
    * auto generate doc.
    * @var mixed
    */
    const CV = 'CV';
    /**
    * auto generate doc.
    * @var mixed
    */
    const MOTIVATION = 'MOTIVATION';
    /**
     * offer document 
     */
    const OFFER = 'OFFER';
    /**
     * recieve mail 
     */
    const MAIL = 'MAIL';
    /**
    * auto generate doc.
    * @param mixed $d    
    */
    protected static function InsertExtraFields($d) {
        $l = igk_getv($d->fields, self::$field_name);
        if (in_array($l, explode('|', 'CV|MOTIVATION|OFFER'))){            
            $d->fields['cardinality'] = 1;            
        }
    }
    /**
    * Triggered when calling an inaccessible or undefined static method.
    * @param mixed $name
    * @param mixed $arguments
    */
    public static function __callStatic($name, $arguments)
    {
        if ($v = self::GetConstantValue($name)){
            $r = self::$model::GetCache(self::$field_name, $v);            
            return $r;
        }
    }
}