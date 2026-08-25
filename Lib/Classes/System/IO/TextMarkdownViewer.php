<?php
// @author: C.A.D. BONDJE DOUE
// @file: MarkdownTextViewer.php
// @date: 20260327 13:02:37
namespace com\igkdev\projects\ForemJobDashboard\System\IO;
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
class TextMarkdownViewer extends FileViewer{
    public function view($node, $content, $ctrl)
    { 
        $fs = Path::Combine($ctrl->getDataDir(), $ctrl->currentLoginPath(), $content->path);
        $node->markdown(file_get_contents($fs));
        $node->div();
    }
}