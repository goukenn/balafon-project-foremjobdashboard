<?php
// @author: C.A.D. BONDJE DOUE
// @desc: global function
// @date: 20240904 08:59:55
use function igk_resources_gets as __;
 igk_reg_hook('sys://user/settings/menu', function($e){
    list($t, $user, $engine) = igk_extract($e->args, 't|user|engine');
    $jctrl = ForemJobDashboardController::ctrl(true); 
    $t->add($engine->menuItem(__('ForemJobs'),'extension-puzzle-outline',[
        'ajx'=>true,
        'href'=>$jctrl::uri('@/settings/joblist')
    ]));  
});