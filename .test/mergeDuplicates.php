<?php
// @author: C.A.D. BONDJE DOUE
// @date: 20260911 15:47:06
// @command: balafon --run .test/mergeDuplicates.php 
/**
* @var mixed $params
* @var mixed $command
* @var mixed $user
*/

use com\igkdev\projects\ForemJobDashboard\Actions\Jobs\DefaultAction;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;

$ctrl = ForemJobDashboardController::ctrl();
$ctrl->login($user);
$id = $ctrl->getUserProfile()->user()->id;
 
$dp = DefaultAction::findDuplicateGroups($id);

foreach($dp as $k=>$rows){
    $owner = array_shift($rows);
    Jobs::clearDuplicates($rows, $owner);
}

igk_wln_e(json_encode($dp, JSON_PRETTY_PRINT));