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
        return compact('interims', 'job_search_engines', 'stats');
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
        return [
            'offers' => count($rows),
            'this month' => count(array_filter($rows, function ($r) use ($month) {
                return substr((string)$r->Create_At, 0, 7) == $month;
            })),
            'important' => count(array_filter($rows, function ($r) {
                return (int)$r->{Jobs::FD_IS_IMPORTANT} == 1;
            })),
        ];
    }
    /**
    * auto generate doc.
    */
    public function logout(){
        $this->getController()->logout();
    }
}