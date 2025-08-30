<?php
// @command: balafon --run src/application/Projects/ForemJobDashboard/Lib/.tests/treatment.php
use com\igkdev\projects\ForemJobDashboard\EnterpriseResponseTemplateManager;
$ctrl = ForemJobDashboardController::ctrl(true);
$r = new EnterpriseResponseTemplateManager;
$r->name = 'Charles BONDJE';
$src = file_get_contents('/Volumes/Data/Dev/PHP/balafon_site_dev/src/application/Projects/ForemJobDashboard/Data/models/response_Model2.template');
$g = $r->treat($src, []);
echo $g;
igk_exit();