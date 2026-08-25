<?php
// @author: C.A.D. BONDJE DOUE
// @file: FileViewer.php
// @date: 20251210 09:37:57
namespace com\igkdev\projects\ForemJobDashboard\System\IO;
use IGK\Controllers\BaseController;
use IGK\Helper\StringUtility;
use IGKException;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\IO
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\IO
*/
abstract class FileViewer{
    /**
     * create 
     * @param string $type 
     * @return ?static 
     */
    public static function CreateFromType(string $type): object{
        $fn = StringUtility::CamelClassName(StringUtility::FuncName($type));
        $cl = __NAMESPACE__."\\".ucfirst($fn)."Viewer";
        if (class_exists($cl)){
            return new $cl();
        }
        throw new IGKException('missing view type : '.$cl);
    }
    /**
    * auto generate doc.
    * @param mixed $node
    * @param mixed|string|object $content
    * @param BaseController $ctrl
    */
    abstract function view($node, $content, BaseController $ctrl);
}