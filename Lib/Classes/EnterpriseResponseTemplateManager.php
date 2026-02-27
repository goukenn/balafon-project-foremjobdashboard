<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseResponseTemplateManager.php
// @date: 20250414 06:08:37
namespace com\igkdev\projects\ForemJobDashboard;
use IGK\System\Regex\Replacement;
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
class EnterpriseResponseTemplateManager{
    /**
     * use name
     * @var ?string
     */
    var $name;

    /**
    * auto generate doc.
    * @var ?string
    */
    var $enterprise_info;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $contact;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $job_title;

    /**
    * auto generate doc.
    * @param string $source
    * @param null|array $info
    */
    public function treat(string $source, ?array $info = null){
        $replacement = new Replacement;
        foreach(['name'] as $k){
            if ($n = igk_getv($this, $k)){
                $replacement->add('/%__'.$k.'__%/', $n);
            }
        }
        if ($info)
        foreach($info as $k=>$v){
            $replacement->add($k,$v);
        }
        $replacement->add('/%__[^\\s]+__%/', "");
        return $replacement->replace($source);
    }
}