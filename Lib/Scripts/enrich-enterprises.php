<?php
// @command: [ENRICH_APPLY=1] [ENRICH_LIMIT=n] balafon --run Lib/Scripts/enrich-enterprises.php
// Fill missing enterprise info from the public KBO/BCE registry (by VAT, else by an unambiguous name match).
// Dry run by default: nothing is written without ENRICH_APPLY=1. Only empty fields are filled; existing values are kept.
// Enterprises with no clear match are listed at the end for manual review.
use com\igkdev\projects\ForemJobDashboard\Models\JobEnterprises;
use com\igkdev\projects\ForemJobDashboard\Services\KboService;
use IGK\System\Console\Logger;

ForemJobDashboardController::ctrl(true);
// options come from the environment: ENRICH_APPLY=1 to write, ENRICH_LIMIT=n to process n enterprises only
$apply = (bool)getenv('ENRICH_APPLY');
$limit = (int)(getenv('ENRICH_LIMIT') ?: 0);
$done = $skipped = $failed = 0;
$review = [];
$taken = []; // formatted vat => enterprise id, seeded with the existing ones
foreach (JobEnterprises::select_all() ?: [] as $x) {
    if ($v = KboService::Normalize((string)$x->{JobEnterprises::FD_VAT})) {
        $taken[KboService::Format($v)] = $x->{JobEnterprises::FD_ID};
    }
}
$todo = array_filter(JobEnterprises::select_all([], ['OrderBy' => [JobEnterprises::FD_NAME . '|ASC']]) ?: [], function ($e) {
    return empty($e->{JobEnterprises::FD_KBO_FETCHED_AT});
});
foreach ($todo as $e) {
    if ($limit && ($done + $skipped + $failed) >= $limit) {
        break;
    }
    $name = $e->{JobEnterprises::FD_NAME};
    $number = KboService::Normalize((string)$e->{JobEnterprises::FD_VAT});
    if (!$number) {
        $number = KboService::PickBest($name, KboService::Search($name));
        usleep(700000);
    }
    if (!$number) {
        $skipped++;
        $review[] = $name;
        continue;
    }
    // vat is unique: never give the same registry number to two enterprises (e.g. "Adecco" / "Adecco Belgium")
    $fmt = KboService::Format($number);
    if (isset($taken[$fmt]) && $taken[$fmt] != $e->{JobEnterprises::FD_ID}) {
        $skipped++;
        $review[] = $name . ' (' . $fmt . ' already used by another enterprise)';
        continue;
    }
    $d = KboService::Fetch($number);
    usleep(700000);
    if (!$d) {
        $failed++;
        $review[] = $name . ' (' . $number . ': fetch failed)';
        continue;
    }
    $map = [
        JobEnterprises::FD_VAT => $d['number'],
        JobEnterprises::FD_TITLE => $d['name'],
        JobEnterprises::FD_ADDRESS => $d['address'],
        JobEnterprises::FD_LOCALITY => $d['locality'],
        JobEnterprises::FD_LEGAL_FORM => $d['legal_form'],
        JobEnterprises::FD_PHONE => $d['phone'],
        JobEnterprises::FD_EMAIL => $d['email'],
        JobEnterprises::FD_WEBSITE => $d['website'],
        JobEnterprises::FD_START_DATE => $d['start_date'],
        JobEnterprises::FD_KBO_STATUS => $d['status'],
    ];
    foreach ($map as $k => $v) {
        if ($v !== null && ($k == JobEnterprises::FD_KBO_STATUS || empty($e->$k))) {
            $e->$k = $v;
        }
    }
    $e->{JobEnterprises::FD_KBO_FETCHED_AT} = date('Y-m-d H:i:s');
    if ($apply) {
        $e->save();
    }
    $taken[$fmt] = $e->{JobEnterprises::FD_ID};
    $done++;
    Logger::print(sprintf('%s => %s %s, %s', $name, $d['number'], $d['name'], $d['locality']));
}
Logger::print(sprintf('%s: %d matched, %d no clear match, %d failed', $apply ? 'APPLIED' : 'DRY RUN', $done, $skipped, $failed));
Logger::print("to review manually:\n  " . implode("\n  ", $review));
igk_exit();
