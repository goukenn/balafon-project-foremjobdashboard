<?php
// @author: C.A.D. BONDJE DOUE
// @file: ApplicationPDFViewer.php
// @date: 20251210 09:47:13
namespace com\igkdev\projects\ForemJobDashboard\System\IO;
use IGK\System\IO\Path;
use function igk_resources_gets as __;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\IO
*/
class ApplicationPDFViewer extends FileViewer{
    /**
    * auto generate doc.
    * @param mixed $node
    * @param mixed $content
    * @param mixed $ctrl
    */
    public function view($node, $content, $ctrl)
    {
        $d = $ctrl->currentLoginPath();
        $node->div()->content = $content->path;
        $fs = Path::Combine($ctrl->getDataDir(), $d, $content->path );
        $fsize = filesize($fs);
        extract(igk_extract_assoc($content?:[], 'remark'));
        $max_view_filesize = $ctrl->getConfigs()->max_view_filesize ??  10 * 1024 * 1024;
        $node->div()->a()->setAttributes([
            'href'=>$ctrl::uri('@/storage/'.base64_encode($d.'/'.$content->path)),
            'download'=>basename($content->path)
        ])->content = __("Download file");
        if ($fsize > $max_view_filesize){
            $node->div()->addClass('igk-alert igk-alert-warning')->content = __("File too large to be displayed");
            return;
        }
        $pdf = file_get_contents($fs);
        $node->iframe()->setAttributes(
            [
                'class'=>'dispb fitw',
                'src'=>'data:application/pdf;base64,'.base64_encode($pdf),
                'height'=>400
            ]
        );
        if ($remark){            
            $node->div()->text($remark);
        }
    }
}