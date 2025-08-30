<?php
// @command: balafon --run src/application/Projects/ForemJobDashboard/Views/.script/cachedid.php
// @author: C.A.D. BONDJE DOUE
// @filename: cachedid.php
// @date: 20250121 11:58:19
// @desc:  
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
$ctrl = ForemJobDashboardController::ctrl(true); 
$r = JobEnterprises::GetCacheIdRowDisplay(7); 
igk_wln_e($r, "end.");