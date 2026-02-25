<?php
// @command: balafon --run src/application/Projects/ForemJobDashboard/Data/treatments/do_treat.php
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
ForemJobDashboardController::ctrl(true);
$titles = [
    'Business analyst',
    'Ingenieur informatique',
    'Analyste Fonctionnel IT',
    'Ingenieur informatique',
    'Business Analyst',
    'Project Manager'
];
$entreprises = [
    'atallnetworks'
];
$jobs = Jobs::select_all([
    Jobs::FD_USER_ID => 3
]);
$enterprises = JobEnterprises::select_all();
$max  =count($titles) - 1;
$summaries = [];
while (count($jobs) > 0) {
    $q = array_shift($jobs);
    if ($q instanceof Jobs) {
        if (empty($q->title)) {
            $v_title = $titles[rand(0, $max)];
            $q->title = $v_title;
        }
        if (empty($q->enterprise_id)){
            $q->enterprise_id = $enterprises[rand(0, count($enterprises)-1)]->id;
        }
        if (empty($q->category_id)){
            $q->category_id = 2;
        }
        if (empty($q->description)){
            if ($summaries){
                $r = $summaries[rand(0,count($summaries)-1)];
                $q->description = $r;
                $q->summary = $r;
            }
        } else {
            $summaries[] = $q->description;
        }
        $q->save();
    }
}
igk_wln_e('d --- ');