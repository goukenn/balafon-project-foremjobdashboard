<?php
// @author: C.A.D. BONDJE DOUE
// @file: UserConfigSetting.php
// @date: 20250825 15:42:12
namespace com\igkdev\projects\ForemJobDashboard;
use com\igkdev\projects\ForemJobDashboard\Models\JobUserSettings;
use com\igkdev\projects\ForemJobDashboard\UserConfigSettingData;
use Error;
use Exception;
use IGK\Helper\Activator;
use IGKException;
use IGK\System\Exceptions\CssParserException;
use IGK\System\Exceptions\ArgumentTypeNotValidException;
use IGK\System\Reflection\Helper\ReflectionHelper;
use ReflectionException;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard
* @author C.A.D. BONDJE DOUE
*/
class UserConfigSetting
{

    /**
    * auto generate doc.
    * @var mixed
    */
    private $m_user_profile;
    /**
     * display title 
     * @var mixed
     */
    var $display;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $firstName;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $lastName;
    /**
     * user app locale 
     * @var ?string locale
     */
    var $locale;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $followDate;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $defaultMotivationTemplate;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $defaultCVTemplate;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $email;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $phone;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $address;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $license;
    /**
     * my title 
     * @var ?string
     */
    var $title;
    /**
     * use signature 
     * @var ?string
     */
    var $signature;
    /**
     * extra data 
     * @var ?object
     */
    var $data;

    /**
    * auto generate doc.
    * @var ?object
    */
    var $social_networks;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $linkedin;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $facebook;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $monsterbe;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $stepstone;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $luxembourg;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $indeed;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $x;
    /**
     * keywords
     * @var string|string[]
     */
    var $keywords;
    /**
     * skills
     * @var ?string[]
     */
    var $skills;

    /**
    * auto generate doc.
    * @var mixed
    */
    var $drivingLicenses;

    /**
    * Used by var_dump() to customize debug output.
    */
    public function __debugInfo()
    {
        return ReflectionHelper::DebugOnlyPublicMember($this);
    }
    /**
     * retrieve job user settings configuration 
     * @param mixed $user 		
     * @return ?static
     * @throws IGKException 
     * @throws Exception 
     */
    public static function DbUserSetting($user)
    {
        $uid = $user->user()->id;
        $v_locale =  $user->model()->clLocale;
        $tab = [];
        $T1 = JobUserSettings::class;
        $r = $T1::select_all([
            $T1::FD_USER_ID => $uid,
        ]);
        foreach ($r as $v) {
            $tv = $v->value;
            if (in_array($v->name, ['data'])) {
                $tv = Activator::CreateNewInstance(UserConfigSettingData::class, json_decode($tv));
            } else if ($tv) {
                if ($data = json_decode($tv)) {
                    if (is_array($data)) {
                        $tv = $data;
                    }
                }
            }
            $tab[$v->name] = $tv;
        }
        if (!isset($tab['locale'])) {
            $tab['locale'] = $v_locale;
        }
        $c = Activator::CreateNewInstance(self::class, $tab);
        $c->m_user_profile = $user;
        return $c;
    }

    /**
    * auto generate doc.
    * @return void
    */
    public function store()
    {
        $T1 = JobUserSettings::class;
        $tab = (array)$this;
        $uid = $this->m_user_profile->user()->id;
        foreach ($tab as $k => $v) {
            if (false !== strpos($k, "\0")) {
                continue;
            }
            $c = [
                $T1::FD_USER_ID => $uid,
                $T1::FD_NAME => $k,
            ];

            /**
            * auto generate doc.
            * @var mixed $c
            */
            if ($c = $T1::insertIfNotExists($c, null, false)) {
                if (is_bool($c)) {
                    if ($c){
                        $c = $T1::last();
                    }
                } 
                if ($c->{$T1::FD_VALUE} != $v) {
                    $c->{$T1::FD_VALUE} = $v;
                    $c->update();
                }
            } 
        }
    }
}