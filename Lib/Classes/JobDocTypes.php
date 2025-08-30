<?php
// @author: C.A.D. BONDJE DOUE
// @file: SourceTypes.php
// @date: 20240905 04:03:45
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes as ModelDockTypes;
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
class JobDocTypes{
    use EnumeratesConstants;
    use ModelTableConstantTrait;
    protected static $model = ModelDockTypes::class;
    protected static $field_name = ModelDockTypes::FD_NAME;
    const DOCUMENT="DOC";
    const MESSAGE="MESSAGE";
    const RESPONSE="RESPONSE";
    const INFO="INFO";
    const FILE="FILE";
    const REMARK="REMARK";
    const CV = 'CV';
    const MOTIVATION = 'MOTIVATION';
    public static function __callStatic($name, $arguments)
    {
        if ($v = self::GetConstantValue($name)){
            $r = self::$model::GetCache(self::$field_name, $v);            
            return $r;
        }
    }
}