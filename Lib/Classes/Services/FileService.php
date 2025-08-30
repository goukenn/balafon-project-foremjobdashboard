<?php
// @author: C.A.D. BONDJE DOUE
// @file: FileService.php
// @date: 20250125 08:55:51
namespace com\igkdev\projects\ForemJobDashboard\Services;
use ForemJobDashboardController; 
use com\igkdev\projects\ForemJobDashboard\JobDocTypes as ConstantJobDocTypes;
use IGK\System\IO\Path;
///<summary></summary>
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Services
* @author C.A.D. BONDJE DOUE
*/
class FileService{
    private $m_controller;
    public function __construct(ForemJobDashboardController $ctrl)
    {
        $this->m_controller = $ctrl;
    }
    public function dirs(){        
        $ctrl = $this->m_controller;
        $dirs = [
            ConstantJobDocTypes::GetCacheData(ConstantJobDocTypes::INFO)->id=>$ctrl->getOfferDir(),
            ConstantJobDocTypes::GetCacheData(ConstantJobDocTypes::RESPONSE)->id=>$ctrl->getResponseDir()
        ];
        return $dirs;
    }
    /**
     * unlink file 
     * @param array $file 
     * @return void 
     */
    public function unlink($file){
        list($path, $type) = $file;
        $dirs = $this->dirs();
        $f = Path::CombineAndFlattenPath($dirs[$type], $path);
        if (igk_io_cache_file_exists($f)){
            @unlink($f);
        }
    }
    public function fileContent($file){
        list($path, $type) = $file;
        $dirs = $this->dirs();
        $f = Path::CombineAndFlattenPath($dirs[$type], $path);
        if (igk_io_cache_file_exists($f)){           
            return file_get_contents($f);
        }
    }
}