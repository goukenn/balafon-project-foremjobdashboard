<?php
// @command: balafon --run src/application/Projects/ForemJobDashboard/Lib/Scripts/store-enterprises.php
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use IGK\System\Console\Logger;

ForemJobDashboardController::ctrl(true);
$enterprise = [];
$store = 0;
$s = igk_getv($params, 0);
foreach(explode(',', $s) as $n){
    if (($n = trim($n)) && !isset($enterprise[$n])){
        if (JobEnterprises::insertIfNotExists([
            JobEnterprises::FD_NAME=>$n
        ])){
            $store ++;
        }
    }
}
Logger::print("store : ". $store);
igk_exit();