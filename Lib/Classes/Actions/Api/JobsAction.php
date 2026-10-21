<?php
// @author: C.A.D. BONDJE DOUE
// @file: Api/Jobs.phtml
// @desc: JSON endpoints backing the jobs UI's async widgets (duplicate detection is a full
//        table scan + grouping, too slow to run synchronously on every jobs page load — see
//        Lib/Classes/Actions/Jobs/DefaultAction::findDuplicateGroups()). Requires a connected
//        user (no dev-mode default-user fallback, unlike the .phtml views) but no specific role.
// @date: 20260911 11:24:55
namespace com\igkdev\projects\ForemJobDashboard\Actions\Api;

use com\igkdev\projects\ForemJobDashboard\Actions\Jobs\DefaultAction as JobsDefaultAction;
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use IGK\Actions\ApiActionBase;
use IGK\System\Http\Request;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions\Api
 * @author C.A.D. BONDJE DOUE
 */
class JobsAction extends ApiActionBase
{
    /**
     * duplicate jobs (same normalized title + enterprise) for the connected user,
     * grouped for the "duplicates" tab badge and listing.
     * @param Request $request
     */
    public function duplicates_get(Request $request)
    {
        $ctrl = $this->getController();
        if (!$ctrl->checkUser(false) || !($profile = $ctrl->getUserProfile())) {
            return $request->error('unauthorized', 401);
        }
        $user = $profile->user();

        $groups = JobsDefaultAction::findDuplicateGroups($user->jbu_id);
        $result = [];
        foreach ($groups as $key => $rows) {
            $result[] = [
                'key' => $key,
                'items' => array_values(array_map(function ($row) {
                    return [
                        'id' => $row->{Jobs::FD_ID},
                        'title' => $row->{Jobs::FD_TITLE},
                        'create_at' => $row->{Jobs::FD_CREATE_AT},
                        'enterprise' => $row->enterprise->name ?? null,
                        'follow_at' => $row->{Jobs::FD_FOLLOW_AT},
                    ];
                }, $rows)),
            ];
        }
        return [
            'count' => array_sum(array_map('count', $groups)),
            'groups' => $result,
        ];
    }
}
