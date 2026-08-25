<?php
// @command: balafon --run src/application/Projects/ForemJobDashboard/Lib/.tests/db/init.response.php
use com\igkdev\projects\ForemJobDashboard\EnterpriseResponseTemplateManager;
use com\igkdev\projects\ForemJobDashboard\Helpers\JobUtility;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;

$ctrl = ForemJobDashboardController::ctrl(true);
$login = igk_getv($params, 0) ?? 'cbondje@igkdev.com';
if (($user = igk_get_user_bylogin($login)) && ($ctrl::login($user, null, false))) {
    $user = $ctrl->getUserProfile()->user();
    $grows = Jobs::select_all([
        Jobs::FD_USER_ID => $user->id
    ]);
    $tc = count($grows) - 1;
    $indexes = array_rand($grows, $tc / 3);
    $models = [
        file_get_contents('/Volumes/Data/Dev/PHP/balafon_site_dev/src/application/Projects/ForemJobDashboard/Data/models/response_Model1.template'),
        file_get_contents('/Volumes/Data/Dev/PHP/balafon_site_dev/src/application/Projects/ForemJobDashboard/Data/models/response_Model2.template'),
        file_get_contents('/Volumes/Data/Dev/PHP/balafon_site_dev/src/application/Projects/ForemJobDashboard/Data/models/response_Model3.template')
    ];
    $rep = new EnterpriseResponseTemplateManager;
    $rep->name = 'Charles';
    while (count($indexes) > 0) {
        $idx = array_shift($indexes);
        $r = $grows[$idx];
        $ri = rand(0, count($models) - 1);
        $src = $models[$ri];
        JobUtility::StoreTemplateResponse($r, $src); 
    }
}
igk_wln_e("done");