<?php
// @author: C.A.D. BONDJE DOUE
// @file: Default.phtml
// @desc: view action Default
// @date: 20250829 15:12:57
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use IGK\Actions\ActionBase;
use com\igkdev\projects\ForemJobDashboard\Models\JobSearchEngines;
use com\igkdev\projects\ForemJobDashboard\Models\JobInterims;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\StatusTypes;
use com\igkdev\projects\ForemJobDashboard\Models\JobSourceTypes;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions
 * @author C.A.D. BONDJE DOUE
 */
class DefaultAction extends ActionBase
{
    /**
    * auto generate doc.
    */
    public function index_get()
    {
        $job_search_engines = JobSearchEngines::select_all();
        usort($job_search_engines, function ($a, $b) {
            return strtolower($a->name) <=> strtolower($b->name);
        });
        $interims = JobInterims::select_all();
        usort($interims, function ($a, $b) {
            return strtolower($a->name) <=> strtolower($b->name);
        });
        $stats = $this->getStats();
        $sources = $this->getSourceStats();
        return compact('interims', 'job_search_engines', 'stats', 'sources');
    }
    /**
     * offers counters of the current user, empty when not logged in
     * @return array label => count
     */
    protected function getStats(): array
    {
        $user = ($profile = $this->getController()->getUserProfile()) ? $profile->user() : null;
        if (!$user) {
            return [];
        }
        $rows = Jobs::select_all([Jobs::FD_USER_ID => $user->jbu_id]) ?: [];
        $month = date('Y-m');
        $today = date('Y-m-d');
        return [
            'offers' => count($rows),
            'this month' => count(array_filter($rows, function ($r) use ($month) {
                return substr((string)$r->Create_At, 0, 7) == $month;
            })),
            'to follow up' => count(array_filter($rows, function ($r) use ($today) {
                $f = $r->{Jobs::FD_FOLLOW_AT};
                return $f && substr($f, 0, 10) <= $today && $r->{Jobs::FD_STATUS_ID} != $this->closedStatusId();
            })),
            'important' => count(array_filter($rows, function ($r) {
                return (int)$r->{Jobs::FD_IS_IMPORTANT} == 1;
            })),
        ];
    }
    protected function closedStatusId()
    {
        return StatusTypes::GetCacheData(StatusTypes::CLOSED)->id ?? null;
    }
    /**
     * offers count by source of the current user, empty when not logged in
     * @return array source name => count (descending)
     */
    protected function getSourceStats(): array
    {
        $user = ($profile = $this->getController()->getUserProfile()) ? $profile->user() : null;
        if (!$user) {
            return [];
        }
        $names = [];
        foreach (JobSourceTypes::select_all() ?: [] as $s) {
            $names[$s->id] = $s->name;
        }
        $result = [];
        foreach (Jobs::select_all([Jobs::FD_USER_ID => $user->jbu_id]) ?: [] as $r) {
            $n = $names[$r->{Jobs::FD_FROM_ID}] ?? '?';
            $result[$n] = ($result[$n] ?? 0) + 1;
        }
        arsort($result);
        return $result;
    }
    /**
    * auto generate doc.
    */
    public function logout(){
        $this->getController()->logout();
    }
}