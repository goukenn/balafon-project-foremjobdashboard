<?php
// @author: C.A.D. BONDJE DOUE
// @filename: clean.desc.php
// @date: 20251124 10:01:22
// @desc: script to clear user's  job database 
// @command: balafon --run src/application/Projects/ForemJobDashboard/Lib/.tests/db/clean.desc.php
// @balafon-usage:
// @balafon-command:forem-job:db-clean
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
$ctrl = ForemJobDashboardController::ctrl(true);
$login = igk_getv($params , 0 ) ?? igk_configs()->default_user;
if (($user = igk_get_user_bylogin($login)) && ($ctrl::login($user, null, false))) {
    $user = $ctrl->getUserProfile()->user();
    //$tab = array_values(array_unique($tab));
    $grows = Jobs::select_all([
        Jobs::FD_USER_ID => $user->id,
        '!'.Jobs::FD_DESCRIPTION=>null
    ]);
    while(count($grows)>0){
        $r = array_shift($grows);
        if ($e = $r->description){
            echo str_repeat('-', 25), PHP_EOL;
            echo $e." ", PHP_EOL;
            $s = readline("clean ? (0|1) - [".$r->id."] ".PHP_EOL);
            if ($s){
                $r->description = null;
                $r->save();
            }
        }
    }
}