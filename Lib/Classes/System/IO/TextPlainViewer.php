<?php
// @author: C.A.D. BONDJE DOUE
// @file: PlainTextViewer.php
// @date: 20260327 12:53:21
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
class TextPlainViewer extends FileViewer{
    public function view($node, $content, BaseController $ctrl)
    {
        $d = $ctrl->currentLoginPath();
        $node->div()->content = $content->path;
        $fs = Path::Combine($ctrl->getDataDir(), $d, $content->path );
        $node->text(file_get_contents($fs)); 
        $node->br(); 
    }
}