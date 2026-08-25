<?php
// @author: C.A.D. BONDJE DOUE
// @file: DocBuilder/Default.phtml
// @desc: view action DocBuilder/Default
// @date: 20260328 08:07:53
namespace com\igkdev\projects\ForemJobDashboard\Actions\DocBuilder;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsersDocuments;
use IGK\Actions\ActionBase;
use IGK\System\Http\Request;
use IGK\System\Security\CurrentUser;

/**
 * view action
 * @package com\igkdev\projects\ForemJobDashboard\Actions\DocBuilder
 * @author C.A.D. BONDJE DOUE
 */
class DefaultAction extends ActionBase
{
    /**
     * auto generate doc.
     * @return
     */
    public function index()
    {
        return [
            'motivation' => implode("\n", [
                '# C.A.D BONDJE DOUE',
                '- motivation'
            ])
        ];
    }
    /**
     * store motivation letter 
     * @return void 
     */
    public function store_post(Request $request)
    {
        if (!($c = $request->get('content'))) {
            $this->die('missing content');
        }
        $uprofile = $this->currentUserProfile();
        $r = JobUsersDocuments::insert([
            JobUsersDocuments::FD_USER_GUID => $uprofile->clGuid,
            JobUsersDocuments::FD_CONTENT => json_encode($c),
            JobUsersDocuments::FD_TYPE => $request->get('type', 'MOTIVATION'),
            JobUsersDocuments::FD_TITLE => $request->get('title'),
        ]);
        return [
            $r
        ];
    }
    /**
     * 
     * @param null|JobUsersDocuments $document 
     * @param null|Request $request 
     * @return mixed 
     */
    public function store_get(?JobUsersDocuments $document, ?Request $request)
    {
        if (is_null($document)) {
            $search = $request->get('search');
            $cond = [];
            if ($search){
                $cond['@@'.JobUsersDocuments::FD_TITLE] = $search;
            }
            $document = JobUsersDocuments::select_all($cond, ['Limit'=>25]);
        }
        return $document;
    }
    /**
     * delete document in store 
     * @param JobUsersDocuments $doc 
     * @return void 
     */
    public function store_del(JobUsersDocuments $doc)
    {
        $doc->delete();
    }
}