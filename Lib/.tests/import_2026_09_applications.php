<?php
// @author: C.A.D. BONDJE DOUE
// @desc: one-off import of Sept 2026 job applications (CV + motivation letter) into ForemJobDashboard
// idempotent: re-running skips any job whose identify (title+company) already exists
use com\igkdev\projects\ForemJobDashboard\Helpers\JobUtility;
use com\igkdev\projects\ForemJobDashboard\Models\JobDoctypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobDocs;
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use com\igkdev\projects\ForemJobDashboard\ContractTypes;
use com\igkdev\projects\ForemJobDashboard\RegisterType;
use com\igkdev\projects\ForemJobDashboard\SourceTypes;
use com\igkdev\projects\ForemJobDashboard\StatusTypes;
use IGK\System\IO\Path;

$DRY_RUN = getenv('DRY_RUN') === '1';

$base = "/Volumes/Data/Documents/CHARLES BONDJE DOUE/CV/2026/2026/09";
$entries = [
    ['company' => 'Approach Cyber', 'title' => 'IT Support Specialist',
        'cv' => "$base/Approach Cyber/IT Support Specialist/ApproachCyber_ITSupportSpecialist_CV.docx",
        'lettre' => "$base/Approach Cyber/IT Support Specialist/ApproachCyber_ITSupportSpecialist_Lettre.docx"],
    ['company' => 'Coinspaid Dev', 'title' => 'Senior PHP Backend Engineer',
        'cv' => "$base/Coinspaid Dev/Senior PHP Backend Engineer/Coinspaid_Senior_PHP_Backend_Engineer_CV.docx",
        'lettre' => "$base/Coinspaid Dev/Senior PHP Backend Engineer/Coinspaid_Senior_PHP_Backend_Engineer_Lettre.docx"],
    ['company' => 'Huxley', 'title' => 'Support Engineer IT',
        'cv' => "$base/Huxley/Support Engineer IT/Huxley_SupportEngineerIT_CV.docx",
        'lettre' => "$base/Huxley/Support Engineer IT/Huxley_SupportEngineerIT_Lettre.docx"],
    ['company' => 'ILIAS Solutions', 'title' => 'Senior Laravel Developer',
        'cv' => "$base/ILIAS Solutions/Senior Laravel Developer/ILIASSolutions_Senior_Laravel_Developer_CV.pdf",
        'lettre' => "$base/ILIAS Solutions/Senior Laravel Developer/ILIASSolutions_Senior_Laravel_Developer_Lettre.docx"],
    ['company' => 'Phished', 'title' => 'Experienced Laravel Backend Engineer',
        'cv' => "$base/Phished/Experienced Laravel Backend Engineer/Phished_Experienced_Laravel_Backend_Engineer_CV.docx",
        'lettre' => "$base/Phished/Experienced Laravel Backend Engineer/Phished_Experienced_Laravel_Backend_Engineer_Lettre.docx"],
    ['company' => 'Proxify', 'title' => 'Senior Laravel Developer',
        'cv' => "$base/Proxify/Senior Laravel Developer/Proxify_Senior_Laravel_Developer_CV.pdf",
        'lettre' => null],
    ['company' => 'Vertuoza', 'title' => 'Developer Back-End',
        'cv' => "$base/Vertuoza/Developer Back-End/Vertuoza_Developer_Back-End_CV.docx",
        'lettre' => "$base/Vertuoza/Developer Back-End/Vertuoza_Developer_Back-End_Lettre.docx"],
    ['company' => 'vind!', 'title' => 'PHP-ontwikkelaar (Full-stack Developer Laravel)',
        'cv' => "$base/vind!/PHP-ontwikkelaar (Full-stack Developer Laravel)/vind_PHPontwikkelaar_CV.docx",
        'lettre' => "$base/vind!/PHP-ontwikkelaar (Full-stack Developer Laravel)/vind_PHPontwikkelaar_Lettre.docx"],
];

$mimeByExt = [
    'pdf' => 'application/pdf',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
];

$ctrl = ForemJobDashboardController::ctrl(true);
$loginPath = 'store/cbondje@igkdev.com';
$storeDir = Path::Combine($ctrl->getDataDir(), $loginPath);

$jobUser = JobUsers::GetCache(JobUsers::FD_ID, 1);
if (!$jobUser) {
    fwrite(STDERR, "ERROR: JobUsers id=1 (cbondje@igkdev.com) not found - aborting\n");
    exit(1);
}

function storeDoc(string $sourcePath, string $mime, string $storeDir, bool $dryRun): array
{
    $ext = pathinfo($sourcePath, PATHINFO_EXTENSION);
    $name = uniqid('doc') . '.' . $ext;
    if (!$dryRun) {
        if (!is_dir($storeDir)) {
            mkdir($storeDir, 0775, true);
        }
        if (!copy($sourcePath, Path::Combine($storeDir, $name))) {
            throw new \Exception("failed to copy $sourcePath");
        }
    }
    return [$name, filesize($sourcePath)];
}

foreach ($entries as $e) {
    $company = $e['company'];
    $title = $e['title'];
    $identify = JobUtility::CreateJobIdentify($title, $company, null);

    if (Jobs::GetCache(Jobs::FD_IDENTIFY, $identify)) {
        echo "SKIP (already exists): $company - $title\n";
        continue;
    }
    if (!is_file($e['cv'])) {
        fwrite(STDERR, "ERROR: CV file missing for $company - $title: {$e['cv']}\n");
        continue;
    }

    $createAt = date('Y-m-d H:i:s', filemtime($e['cv']));
    echo ($DRY_RUN ? "[DRY RUN] " : "") . "CREATE: $company - $title (identify=$identify, date=$createAt)\n";

    if ($DRY_RUN) {
        continue;
    }

    $enterprise = JobEnterprises::GetCache(JobEnterprises::FD_NAME, $company, true);

    $d = [
        Jobs::FD_GUID => igk_create_guid(),
        Jobs::FD_TITLE => $title,
        Jobs::FD_FROM_ID => SourceTypes::GetCacheData(SourceTypes::WEB),
        Jobs::FD_TYPE_ID => RegisterType::GetCacheData(RegisterType::REAL),
        Jobs::FD_CONTRACT_ID => ContractTypes::GetCacheData(ContractTypes::EMPOYEE),
        Jobs::FD_STATUS_ID => StatusTypes::GetCacheData(StatusTypes::OPENED),
        Jobs::FD_ENTERPRISE_ID => $enterprise->id,
        Jobs::FD_USER_ID => $jobUser->id,
        Jobs::FD_IDENTIFY => $identify,
        Jobs::FD_CREATE_AT => $createAt,
        Jobs::FD_UPDATE_AT => $createAt,
    ];
    $job = Jobs::insert($d);
    if (!$job) {
        fwrite(STDERR, "ERROR: failed to insert job for $company - $title\n");
        continue;
    }

    $docs = ['cv' => 'CV', 'lettre' => 'MOTIVATION'];
    foreach ($docs as $key => $typeName) {
        $sourcePath = $e[$key];
        if (!$sourcePath) {
            continue;
        }
        $ext = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        $mime = $mimeByExt[$ext] ?? 'application/octet-stream';
        [$storedName, $size] = storeDoc($sourcePath, $mime, $storeDir, false);
        $docType = JobDoctypes::GetCache('name', $typeName);
        JobDocs::insert([
            JobDocs::FD_JOB_ID => $job->{Jobs::FD_ID},
            JobDocs::FD_JOB_DOC_TYPE_ID => $docType->id,
            JobDocs::FD_VALUE => json_encode((object)[
                'path' => $storedName,
                'type' => $mime,
                'size' => $size,
                'remark' => null,
            ]),
        ]);
        echo "  + $typeName -> $storedName ($sourcePath)\n";
    }
}

echo "done.\n";
