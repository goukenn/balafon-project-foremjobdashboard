<?php
// @author: C.A.D. BONDJE DOUE
// @desc: global function
// @date: 20240904 08:59:55
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use function igk_resources_gets as __;

// igk_reg_hook(IGKEvents::HOOK_WINUI_SETTING_MENU, function($e){
//     list($t, $user, $engine) = igk_extract($e->args, 't|user|engine');
//     $jctrl = ForemJobDashboardController::ctrl(true); 
//     $t->add($engine->menuItem(__('ForemJobs'),
//         'extension-puzzle-outline',[
//         'ajx'=>true,
//         'href'=>$jctrl::uri('@/settings/joblist'),
//         'data-arg'=>['store-ref'=>true]
//     ]));
//     $t->add($engine->menuItem(__('ForemJobs Security'),
//         'lock-closed-outline',[
//         'href'=>$jctrl::uri('@/settings/security'),
//     ]));
// });
igk_reg_hook(IGKEvents::HOOK_USER_CLEAN, function($e){
    list($user) = igk_extract($e->args, 'user'); 
    $cond = [
        JobUsers::FD_GUID=>$user->clGuid
    ];
    $row = JobUsers::select_row($cond);
    if ($row){
        Jobs::delete([
            Jobs::FD_USER_ID=>$row->id
        ]);
        JobUsers::delete($cond);
    }
});