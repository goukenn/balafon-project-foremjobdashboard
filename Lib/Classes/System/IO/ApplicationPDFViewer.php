<?php
// @author: C.A.D. BONDJE DOUE
// @file: ApplicationPDFViewer.php
// @date: 20251210 09:47:13
namespace com\igkdev\projects\ForemJobDashboard\System\IO;
use IGK\System\IO\Path;
use function igk_resources_gets as __;
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\IO
* @author C.A.D. BONDJE DOUE
*/
class ApplicationPDFViewer extends FileViewer{
    public function view($node, $content, $ctrl)
    {
        $d = $ctrl->currentLoginPath();
        $node->div()->content = $content->path;
        $fs = Path::Combine($ctrl->getDataDir(), $d, $content->path );
        $fsize = filesize($fs);
        $max_view_filesize = $ctrl->getConfigs()->max_view_filesize ??  10 * 1024 * 1024;
        if ($fsize > $max_view_filesize){
            $node->div()->addClass('igk-alert igk-alert-warning')->content = __("File too large to be displayed");
            $node->div()->a()->setAttributes([
                'href'=>$ctrl::uri('@/storage/'.base64_encode($d.'/'.$content->path)),
                'download'=>'download'
            ])->content = "Download File";
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
    }
}