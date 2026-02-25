<?php
namespace com\igkdev\projects\ForemJobDashboard\Database;
use com\igkdev\projects\ForemJobDashboard\Models\JobUserSettings;
use IGK\Models\Users;
class Utility{
    public static function GetAllJobs(Users $user){
    }
    /**
     * 
     * @param mixed $user use profile 
     * @param string $v 
     * @return mixed 
     */
    public static function GetUserSetting($user, string $v){
        $T1 = JobUserSettings::class;
        /**
         * @var mixed
         */
        $r= $T1::select([
            $T1::FD_USER_ID=>$user->user()->id,
            $T1::FD_NAME =>$v
        ]);
        if ($r && ($r = array_shift($r))){
            return $r->{$T1::FD_VALUE};
        }
        return null;
    }
}