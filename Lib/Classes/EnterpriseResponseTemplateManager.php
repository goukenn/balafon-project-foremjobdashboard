<?php
// @author: C.A.D. BONDJE DOUE
// @file: EnterpriseResponseTemplateManager.php
// @date: 20250414 06:08:37
namespace com\igkdev\projects\ForemJobDashboard;
use IGK\System\Regex\Replacement;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
class EnterpriseResponseTemplateManager{
    /**
     * use name
     * @var ?string
     */
    var $name;
    /**
     * 
     * @var ?string
     */
    var $enterprise_info;
    /**
     * 
     * @var mixed
     */
    var $contact;
    /**
     * 
     * @var mixed
     */
    var $job_title;
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