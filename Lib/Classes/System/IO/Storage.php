<?php
// @author: C.A.D. BONDJE DOUE
// @file: Storage.php
// @date: 20251210 09:14:44
namespace com\igkdev\projects\ForemJobDashboard\System\IO;
use IGK\Controllers\BaseController;
use IGK\System\IO\Path;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\IO
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\IO
*/
class Storage{

    /**
    * auto generate doc.
    * @var mixed
    */
    var $data_dir;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $ctrl;

    /**
    * .ctr
    * @param string $data
    * @param BaseController $ctrl
    */
    public function __construct(string $data, BaseController $ctrl)
    {
        $this->data_dir = $data; 
        $this->ctrl = $ctrl;
    }

    /**
    * auto generate doc.
    * @return string
    */
    public function getFile(): string{
        return Path::Combine($this->ctrl->getDataDir(), $this->data_dir);
    }

    /**
    * auto generate doc.
    * @return void
    */
    public function moveUpload(string $file, string $path){
        $dir = $this->getFile(); 
        return igk_io_move_uploaded_file($file, Path::Combine($dir,  $path));
    }

    /**
    * auto generate doc.
    */
    public function unlink(){
        $dir = $this->getFile(); 
        @unlink($dir);
    }
}