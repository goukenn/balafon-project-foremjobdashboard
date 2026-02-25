<?php
// @author: C.A.D. BONDJE DOUE
// @file: Storage.php
// @date: 20251210 09:14:44
namespace com\igkdev\projects\ForemJobDashboard\System\IO;
use IGK\Controllers\BaseController;
use IGK\System\IO\Path;
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\IO
* @author C.A.D. BONDJE DOUE
*/
class Storage{
    var $data_dir;
    var $ctrl; 
    public function __construct(string $data, BaseController $ctrl)
    {
        $this->data_dir = $data; 
        $this->ctrl = $ctrl;
    }
    public function getFile(): string{
        return Path::Combine($this->ctrl->getDataDir(), $this->data_dir);
    }
    /**
     * 
     * @param string $file 
     * @param string $path 
     * @return void 
     */
    public function moveUpload(string $file, string $path){
        $dir = $this->getFile(); 
        return igk_io_move_uploaded_file($file, Path::Combine($dir,  $path));
    }
    public function unlink(){
        $dir = $this->getFile(); 
        @unlink($dir);
    }
}