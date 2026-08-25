<?php
// @author: C.A.D. BONDJE DOUE
// @file: Default.phtml
// @desc: view action Default
// @date: 20250829 15:12:57
namespace com\igkdev\projects\ForemJobDashboard\Actions;
use IGK\Actions\ActionBase;
use com\igkdev\projects\ForemJobDashboard\Models\JobSearchEngines;
use com\igkdev\projects\ForemJobDashboard\Models\JobInterims;

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
        return compact('interims', 'job_search_engines');
    }
    /**
    * auto generate doc.
    */
    public function logout(){
        $this->getController()->logout();
    }
}