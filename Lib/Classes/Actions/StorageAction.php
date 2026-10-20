<?php
// @author: C.A.D. BONDJE DOUE
// @file: Storage.phtml
// @desc: view action Storage
// @date: 20251211 18:48:56
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use com\igkdev\projects\ForemJobDashboard\System\IO\Storage;
use igk;
use IGK\Actions\ActionBase;

/**
* view action
* @package com\igkdev\projects\ForemJobDashboard\Actions
* @author C.A.D. BONDJE DOUE
*/
class StorageAction extends ActionBase{
    /**
    * auto generate doc.
    * @param string $path_encoded
    */
    public function index_get(string $path_encoded){
        if (igk_valid_cref(false) || $this->getUser()){
            $ctrl = $this->getController();
            $rel = str_replace('\\', '/', base64_decode($path_encoded));
            $base = $ctrl->currentLoginPath();
            if (strpos($rel, '..') !== false || strpos($rel, $base . '/') !== 0){
                igk_die('not allowed', true, 403);
            }
            $storage = new Storage($rel, $ctrl);
            $file = $storage->getFile();
            if (!is_file($file)){
                igk_die('file not found', true, 404);
            }
            igk_download_file(basename($file), $file);
            igk_exit(); 
        }
        igk_die('not allowed', true, 403);
    }   
}