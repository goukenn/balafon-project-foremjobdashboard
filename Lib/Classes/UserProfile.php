<?php
// @author: C.A.D. BONDJE DOUE
// @file: UserProfile.php
// @date: 20250219 09:55:21
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use Exception;
use IGK\Helper\Authorization;
use IGK\Models\ModelBase;
use IGK\Models\Users;
use IGK\System\SystemUserProfile;
///<summary>data : </summary>
/**
* use profiles data - 
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
class UserProfile extends SystemUserProfile{
    /**
     * override de profileModelClass 
     */
    const profileModelClass = JobUsers::class;
    /**
     * @var JobUsers
     */
    protected $m_projectUser;
    public function __construct()
    {
    }
    /**
     * 
     * @param Users $user 
     * @return void 
     * @throws Exception 
     */
    protected function initProjectDbUser(Users $user){
        if (is_null($v_user = JobUsers::GetCache(JobUsers::FD_GUID, $user->clGuid))){
            $v_user = $this->createNewProjectUser($user, JobUsers::class);
        }
        ($this->m_projectUser = $v_user) ?? igk_die('missing project user');
    }
    protected function getdbCacheColumnList($class_name){
        return [JobUsers::FD_GUID, IGK_FD_GUID];
    }
    /**
     * create new Project Users
     * @param Users $user 
     * @param string $model_class 
     * @return mixed 
     */
    protected function createNewProjectUser(Users $user, string $model_class)
    {
        if ($model_class==JobUsers::class){
            return JobUsers::createIfNotExists([
                JobUsers::FD_GUID=>$user->clGuid,
            ]);
        }
    }
    /**
     * register profile 
     * @return mixed 
     */
    protected function registerProfile() { 
        // what to do to register profile to 
        if ($this->m_projectUser->isNew()){
            Authorization::BindUserToGroup($this->getController(), $this->model(),  'consultant');
        }
    }
    /**
     * project user
     * @return ModelBase 
     */
    public function user(): ModelBase { 
        return $this->m_projectUser;
    }
}