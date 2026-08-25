<?php
// @author: C.A.D. BONDJE DOUE
// @filename: 
// @date: 20250414 07:52:20
// @desc: init enterprise with var 
// @command: balafon --run src/application/Projects/ForemJobDashboard/Views/.script/init_enterprise_from_sites.php
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\SiteNoteBook\Models\Sites;

$g = ForemJobDashboardController::ctrl(true);
$site = SiteNoteBookController::ctrl(true);
$enterprises = (function () {
    $e = [];
    foreach (Sites::select_all() as $m) {
        if ($m->{Sites::FD_VAT}) {
            $e[] = $m;
        }
    }
    return $e;
})();
/**
 * load enterprises
 */
$register = [];
foreach ($enterprises as $rr) {
    $name = $rr->{Sites::FD_NAME};
    $vat = $rr->{Sites::FD_VAT};
    if (! JobEnterprises::GetCache(JobEnterprises::FD_NAME, $name)) {
        JobEnterprises::Add($name, $vat);
        $register[]
            = $name;
    }
}