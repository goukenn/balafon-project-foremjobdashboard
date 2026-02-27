<?php
// @author: C.A.D. BONDJE DOUE
// @file: ForemJobDashboardController.php
// @date: 20240904 08:59:55
use com\igkdev\projects\ForemJobDashboard\Models\Jobs;
use com\igkdev\projects\ForemJobDashboard\Models\JobUsers;
use com\igkdev\projects\ForemJobDashboard\Services\FileService;
use IGK\Controllers\ApplicationController;
use IGK\Models\Users;
use IGK\System\Applications\ApplicationUserProfile;
use IGK\System\Database\IUserProfile;
use IGK\System\Regex\RegexHelper;
///<summary>Controller entry point</summary>
/**
 * Controller entry point
 * @author C.A.D. BONDJE DOUE
 */
class ForemJobDashboardController extends ApplicationController
{
    /**
     * get file service in used 
     * @return FileService 
     */
    protected function getFileService()
    {
        return new FileService($this);
    }
    /**
     * sign in user 
     * @param mixed &$user 
     * @param mixed $login 
     * @return void 
     * @throws Exception 
     */
    protected static function SignInUser($login = null)
    {
        $login = $login ?? igk_getv($_ENV, 'IGK_DEFAULT_USER') ?? igk_die('missing default user');
        $user = igk_get_user_bylogin($login);
        if (!$user) {
            $user = Users::Register([
                Users::FD_CL_LOGIN => $login,
                Users::FD_CL_STATUS => 1
            ]) ?? igk_die("failed to register");
        }
        return $user;
    }

    /**
    * auto generate doc.
    * @return void
    */
    protected function outputDownload($info = null)
    {
        extract(array_merge($info ?? [], ['ctrl' => $this]));
        return include $this->getClassesDir() . '/../Scripts/download.php';
    }
    /**
     * current login path 
     * @param IUserProfile|null $u user
     * @return string 
     */
    protected function currentLoginPath(
        $u = null
    ): string {

        /**
        * auto generate doc.
        * @var IUserProfile|null $u
        */
        $s = 'store';
        $u = $u ?? $this->getUserProfile();
        if (($u) && ($login = $u->{'clLogin'})){
            $s .= '/' . $login;
        } 
        return $s;
    }

    /**
    * auto generate doc.
    */
    protected function getOfferDir()
    {
        return $this->getDataDir() . $this->currentLoginPath() . '/db/offers/';
    }

    /**
    * auto generate doc.
    */
    protected function getResponseDir()
    {
        return $this->getDataDir() . $this->currentLoginPath() . '/db/response/';
    }
    /**
     * override forced session uri 
     * @return array<string|int, int> 
     */
    protected function forceSessionUris()
    {
        return [
            $this->uriPath('@/api/docs') => 1,
            function ($d) {
                $l = $this->uriPath('/api');
                $l = RegexHelper::Escape($l);
                return preg_match('/' . $l . '/', $d);
            }
        ];
    }
}