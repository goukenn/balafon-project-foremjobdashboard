<?php
// + | --------------------------------------------------------------------
// + | load entries of job services 
// + |
// @author: C.A.D. BONDJE DOUE
// @filename: pload.entries.php
// @date: 20250121 12:05:58
// @desc: load site notebook to forem job dashboard
// @command: balafon --run ./src/application/Projects/ForemJobDashboard/Views/.script/pload.entries.php
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\SiteNoteBook\Models\Sites; 
use IGK\System\Console\Logger;

$g = ForemJobDashboardController::ctrl(true);
$site = SiteNoteBookController::ctrl(true);
$uid  = null;
$login = igk_getv($params, 0) ?? 'cbondje@igkdev.com';
if (($user = igk_get_user_bylogin($login)) && ($g::login($user, null, false))) {
    $user = $g->getUserProfile()->user();
    $uid = $user->id;
}
$file = __DIR__.'/data/titres_offres_emploi.csv';
$r = array_filter(explode("\n", str_replace("\r", "", file_get_contents($file))));
$conditions =[
    '@@'.Jobs::FD_CREATE_AT => "2023-%", 
];
if ($uid){
    $conditions[Jobs::FD_USER_ID] = $uid;
}
$rows = Jobs::select_all(
    $conditions
);
$list = range(1, count($rows));
shuffle($list);
while(count($list)>0){
    $indx = rand(0, count($list) -1);
    $lp = $list[$indx];
    unset($list[$indx]);
    $list = array_values($list);     
    $c = igk_getv($rows, $lp);
    if ($c){
        $title = $c->{Jobs::FD_TITLE} ?? igk_getv($r, $lp, 'Unknow');
        $c->{Jobs::FD_TITLE} = $title;
        $c->{Jobs::FD_DESCRIPTION} = null;
        $c->{Jobs::FD_SUMMARY} = null;
        $c->{Jobs::FD_CONTACT_ID} = null;
        if (  $c->{Jobs::FD_ENTERPRISE_ID} == 0){
            $c->{Jobs::FD_ENTERPRISE_ID} = JobEnterprises::GetCache(JobEnterprises::FD_NAME, 'Unknow', true);
        }
        $c->save();
    }
}
include(__DIR__ . '/init_enterprise_from_sites.php'); 
Logger::success('complete');
igk_exit(0);