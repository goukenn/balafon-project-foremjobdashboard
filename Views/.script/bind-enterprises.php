<?php
// + | --------------------------------------------------------------------
// + | automatic bind array - enterprise to list  
// + |
// @command: balafon --run src/application/Projects/ForemJobDashboard/Views/.script/bind-enterprises.php
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\System\Console\Logger;
use IGK\System\Database\SQLQueryFieldPrefixOperators;

$ctrl = ForemJobDashboardController::ctrl(true);
$e_utility = $ctrl->modelUtility('enterprise');
$enterprises = [
    'IBM',
    'Microsoft',
    'Oracle',
    'SAP',
    'WaveStone',
    'CGI',
    'Capgemini',
    'Accenture'
];
array_map(function ($i) use (&$enterprises) {
    $n = $i->{JobEnterprises::FD_NAME};
    if (preg_match("/ecolor|mr|vdab|bpost|startpeople/i", $n))
        return;
    $enterprises[] = $i->{JobEnterprises::FD_NAME};
}, JobEnterprises::select_all());
array_unique($enterprises);
$login = igk_getv($params, 0) ?? 'cbondje@igkdev.com';
if (($user = igk_get_user_bylogin($login)) && ($ctrl::login($user, null, false))) {
    $user = $ctrl->getUserProfile()->user();
    $grows = Jobs::select_all([
       Jobs::FD_USER_ID => $user->id,
       SQLQueryFieldPrefixOperators::FIND.Jobs::FD_CREATE_AT=>'2025%' 
    ]);
    $update = 0;
    while(count($grows) > 0 ){
        $r = array_shift($grows);
        $eid = $r->{Jobs::FD_ENTERPRISE_ID};
        if (empty($eid) || ($eid == 56)){
            $eidx = rand(0, count($enterprises) - 1);
            $n = $enterprises[$eidx];
            $e_id = $e_utility->registerEnterprise($n); 
            $r->{Jobs::FD_ENTERPRISE_ID} = $e_id;
            $r->save();
            $update++;
        }
    } 
    Logger::print('update : '.$update); 
}
igk_exit();