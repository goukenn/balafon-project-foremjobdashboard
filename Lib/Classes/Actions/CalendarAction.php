<?php
// @author: C.A.D. BONDJE DOUE
// @file: CalendarAction.php
// @desc: user's appointment calendar (list, recalls, ICS export for Calendar.app / Google Calendar)
namespace com\igkdev\projects\ForemJobDashboard\Actions;

use com\igkdev\projects\ForemJobDashboard\Models\JobAppointments;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Services\CalendarService;
use IGK\Actions\ActionBase;
use IGK\Actions\ApiActionBase;

/**
 * view action. POST handlers (<name>_post) are dispatched by naming convention, like EnterpriseAction.
 * @package com\igkdev\projects\ForemJobDashboard\Actions
 */
class CalendarAction extends ActionBase
{
    /**
     * handlers redirect or stream a file themselves: let array results render the view
     */
    // protected function _handleResponse($response): bool
    // {
    //     if (igk_is_ajx_demand()) {
    //         return true;
    //     }
    //     return !is_array($response);
    // }
    public function index()
    {
        $uid = $this->userId();
        $jobs = $uid ? (Jobs::select_all([Jobs::FD_USER_ID => $uid]) ?: []) : [];
        return [
            'events' => $uid ? CalendarService::All($uid) : [],
            'due' => $uid ? CalendarService::Due($uid) : [],
            'jobs' => $jobs,
            'token' => $uid ? CalendarService::FeedToken($uid) : null,
        ];
    }
    /**
     * the module's own user id (jobs.user_id), 0 when not logged in
     */
    public function userId(): int
    {
        $p = $this->getController()->getUserProfile();
        return ($p && ($u = $p->user())) ? (int)$u->jbu_id : 0;
    }
    /**
     * create or update an appointment
     */
    public function save_post()
    {
        $uid = $this->requireUser();
        $id = (int)igk_getr('id') ?: null;
        $r = CalendarService::Save($uid, $id, [
            'title' => igk_getr('title'), 'kind' => igk_getr('kind'), 'job_id' => igk_getr('job_id'),
            'start_at' => igk_getr('start_at'), 'end_at' => igk_getr('end_at'), 'remind_at' => igk_getr('remind_at'),
            'location' => igk_getr('location'), 'contact_email' => igk_getr('contact_email'), 'notes' => igk_getr('notes'),
        ]);
        $this->back($r instanceof JobAppointments ? '?ok=1' : '?err=' . $r . ($id ? '&e=' . $id : ''));
    }
    public function status_post()
    {
        CalendarService::SetStatus($this->requireUser(), (int)igk_getr('id'), (string)igk_getr('status'));
        $this->back('?ok=1');
    }
    public function snooze_post()
    {
        CalendarService::Snooze($this->requireUser(), (int)igk_getr('id'), (int)igk_getr('days') ?: 1);
        $this->back('?ok=1');
    }
    public function delete_post()
    {
        CalendarService::Delete($this->requireUser(), (int)igk_getr('id'));
        $this->back('?deleted=1');
    }
    /**
     * revoke the current feed address and create a new one
     */
    public function token_post()
    {
        CalendarService::RegenerateToken($this->requireUser());
        $this->back('?ok=1');
    }
    /**
     * one appointment as a downloadable .ics file (?id=)
     */
    public function ics_get()
    {
        $uid = $this->requireUser();
        $e = CalendarService::Get($uid, (int)igk_getr('id')) ?: igk_die('not found', true, 404);
        $this->sendIcs([$e], $e->{JobAppointments::FD_TITLE});
    }
    /**
     * subscription feed (?t=). Public by url (calendar apps cannot log in): the secret token identifies
     * the user. Reachable without session, see ForemJobDashboardController::forceSessionUris().
     */
    public function feed_get()
    {
        $uid = CalendarService::UserIdByToken((string)igk_getr('t'));
        if (!$uid) {
            igk_die('not found', true, 404);
        }
        $this->sendIcs(CalendarService::All($uid), 'Forem Job Dashboard');
    }
    private function requireUser(): int
    {
        return $this->userId() ?: igk_die('not allowed', true, 403);
    }
    /**
     * post/redirect/get
     */
    private function back(string $query): void
    {
        igk_navto($this->getController()::uri('@/calendar') . $query);
    }
    private function sendIcs(array $events, string $name): void
    {
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: inline; filename="calendar.ics"');
        header('Cache-Control: private, max-age=300');
        echo CalendarService::BuildIcs($events, $name);
        igk_exit();
    }
}
