<?php
// @authenticator management 
if (!$ctrl->checkUser(false)){ 
    $def_user = igk_configs()->default_user ; 
    if ($def_user && (!($user = igk_get_user_bylogin( igk_configs()->default_user ) ) || (!$ctrl::login($user, null, false)))){        
        $t->container()->h2('missing user');
        return;
    } else {
        igk_navto($ctrl::uri('/login'));
    } 
}
$user = $ctrl->getUserProfile()->user(); 