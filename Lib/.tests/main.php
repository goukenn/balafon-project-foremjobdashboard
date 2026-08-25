<?php
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Helper\IO;
use IGK\Helper\JSon;

$ctrl = ForemJobDashboardController::ctrl(true);
$dirs = ['/Volumes/Data/Dev/PHP/balafon_site_dev/src/application/Projects/ForemJobDashboard/Views/output',
'/Users/charlesbondjedoue/Desktop/jobs'];
while (count($dirs) > 0) {
    $dir = array_shift($dirs);
    foreach (IO::GetFiles($dir, '/_offre.+\.pdf$/', true) as $f) {
        $n = explode("_", igk_io_basenamewithoutext($f), 2);
        if (empty($n[0])) continue;
        JobEnterprises::GetCache(JobEnterprises::FD_NAME, trim($n[0]), true);
    }
}
echo JSon::Encode(JobEnterprises::select_all(), null, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
exit;
$tab = [
    "Full Stack .NET / Python Developer",
    "Full Stack .NET / Angular Developer",
    "Développeurs .NET",
    "Développeur .NET Senior",
    ".NET &amp; React Developper",
    "Senior .NET Specialist",
    "Sharepoint Developer",
    "Fullstack Java Developer",
    "Technical Analyst",
    "JavaScript Full-stack Developer",
    "Senior Java Developer",
    "Développeur Java Medior",
    "Java Developer",
    ".Net Developer",
    "PHP Developer",
    "Software Developer .NET",
    "Senior .NET Developer",
    "Python Software Engineer",
    "Development Manager",
    "Développeurs .NET",
    "Développeur .NET Senior",
    ".NET &amp; React Developper",
    "Technical Analyst",
    "Senior Java Developer",
    "Développeur Java Medior",
    "Java Developer",
    ".Net Developer",
    "Development Manager",
    "Analyste Développeur Medior / Senior Python - Odoo",
    "Freelance Developpeur Back-end PHP",
    "ICT Project Manager"
];
$login = 'cbondje@igkdev.com';
if (($user = igk_get_user_bylogin($login)) && ($ctrl::login($user, null, false))) {
    $user = $ctrl->getUserProfile()->user();
    $tab = array_values(array_unique($tab));
    $grows = Jobs::select_all([
        Jobs::FD_USER_ID => $user->id
    ]);
    $tc = count($tab) - 1;
    while (count($grows)) {
        $r = array_shift($grows);
        $c = rand(0, $tc);
        $r->{Jobs::FD_TITLE} = $tab[$c % $tc];
        $r->save();
    }
}
igk_wln_e("finish");