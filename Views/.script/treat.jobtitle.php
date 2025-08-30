<?php
// + | --------------------------------------------------------------------
// + | automatic bind array - enterprise to list  
// + |
 // @command: balafon --run /Volumes/Data/wwwroot/core/Projects/ForemJobDashboard/Views/.script/treat.jobtitle.php
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\System\Console\Logger;
$ctrl = ForemJobDashboardController::ctrl(true); 
$login = igk_getv($params, 0) ?? 'cbondje@igkdev.com';
if (($user = igk_get_user_bylogin($login)) && ($ctrl::login($user, null, false))) {
    $user = $ctrl->getUserProfile()->user();
    //$tab = array_values(array_unique($tab));
    $grows = Jobs::select_all([
        Jobs::FD_USER_ID => $user->id,
        // "@@".Jobs::FD_CREATE_AT=>'2025%' // year to bind 
    ]);
    $update = 0;
    while(count($grows) > 0 ){
        $r = array_shift($grows);
        $title = $r->{Jobs::FD_TITLE};
        $ntitle = igk_str_remove_quote(trim($title, " ,"));
        $ntitle = str_replace('&amp;', '&' , $ntitle);
        if ($ntitle != $title){   
            $r->{Jobs::FD_TITLE} =  $ntitle;
            $r->save();
            $update++;
        }
    } 
    Logger::print('update : '.$update); 
}
igk_exit();