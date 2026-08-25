<?php
// @command: balafon --run ./src/application/Projects/ForemJobDashboard/Views/.script/treat.job.source.php --querydebug
// @author: C.A.D. BONDJE DOUE
// @filename: treat.job.source.php
// @date: 20250121 12:03:33
// @desc: used to import existing data 
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;
use com\igkdev\projects\ForemJobDashboard\SourceTypes;

/**
 * description information 
 * @property string $title title of the jobs
 * @property string $description description of the tile 
 * @property string $skills list of skill required to 
 */
interface ITypeDescription{
}
$ctrl = ForemJobDashboardController::ctrl(true);
$file = igk_getv($params, 0);
$source_ids = [
    JobSourceTypes::GetCache(JobSourceTypes::FD_NAME, SourceTypes::ICTJOB)->{JobSourceTypes::FD_ID},
    JobSourceTypes::GetCache(JobSourceTypes::FD_NAME, SourceTypes::LINKEDIN)->{JobSourceTypes::FD_ID},
    JobSourceTypes::GetCache(JobSourceTypes::FD_NAME, SourceTypes::WEB)->{JobSourceTypes::FD_ID}
];
$v_descfile = __DIR__.'/data/desc.json'; 
$desc = json_decode(file_get_contents($v_descfile));
$Tcount = count($desc);
if (!$Tcount){
    igk_die("missing desc");
}
$file = $file ?? __DIR__.'/data/db.json';
if (!igk_io_cache_file_exists($file)){
    igk_die('missing file file to import');
}
if (!($data = json_decode(file_get_contents($file)))){
    igk_die('no data found.');
}
$list = [];
$count = 0;
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
$e_utility = $ctrl->modelUtility('enterprise');
$count = 0;
foreach ($data as $k => $v) {
    if (in_array($v->jbs_id, [2, 322]) || !empty($v->jbs_description))
        continue;
    if (count($list)>= $Tcount){
        break;
    }
    while (isset($list[$idx = rand(0, $Tcount - 1)]));
    $eidx = rand(0, count($enterprises) - 1);
    $n = $enterprises[$eidx];
    $e_id = $e_utility->registerEnterprise($n); 
    $list[$idx] = 1;
    $p = (object)igk_getv($desc, $idx);
    if (null === $p->title) {
        igk_wln_e("missing title");
    }
    $de = '';
    if ((rand(0, 18) % 12) == 0) {
        $de = 'Spontanée';
    } else {
        $de =  [$p->description];
        if ($p->skills && rand(0, 1)) {
            $de[] = 'Skills : ' . implode(",", array_filter($p->skills));
        }
        $de[] = 'Contact : website';
        $de = str_replace("\r", "", implode("\n", $de));
    }
    $v->jbs_title = $p->title;
    $v->jbs_description = $de;
    $v->jbs_summary = null;
    $v->{Jobs::FD_FROM_ID} = rand(0, 2);
    if (   $v->{Jobs::FD_ENTERPRISE_ID} != $e_id ){
        $v->{Jobs::FD_ENTERPRISE_ID} = $e_id; 
    }
    $count++; 
}
igk_wln_e("ok -::::- " . $count);