<?php
// @command: balafon --run src/application/Projects/ForemJobDashboard/Views/api/check_handle.php
use igk\docs\swagger\Models\SwaggerOAuth as ModelsSwaggerOAuth;
use igk\docs\swagger\System\Http\Request\SwaggerOAuth;
use IGK\System\Console\Colorize;
use IGK\System\Console\Logger;
use IGK\System\Http\Request;

$user = igk_get_user_bylogin('cbondje@igkdev.com');
Logger::SetColorizer(new Colorize);
$expire_at =  date('Y-m-d H:i:s', strtotime('+1 month'));
/**
* auto generate doc.
* @param mixed $user
*/
function gen_client_id($user){
    return hash('sha256', implode("", [
        igk_app()->getConfigs()->hashKey,
        $user->clLogin,
        $user->clGuid,
        date('YmdTHis')]));
};
$l = gen_client_id($user); 
ModelsSwaggerOAuth::insertIfNotExists([
    "client_id"=>$l,
    "user_id"=>$user->clGuid,
    "Expire_At"=>$expire_at
]);
$g = ModelsSwaggerOAuth::select_all();
$c = $g[0];
echo json_encode([
    'isExpired'=> $c->isExpired()
], JSON_PRETTY_PRINT);
$expireds = ModelsSwaggerOAuth::SelectAllExpired();
ob_start();
igk_wln("expired : ", $expireds);
igk_wln($g, json_encode($g[0]->to_array(), JSON_PRETTY_PRINT));
$c = ob_get_contents();
ob_end_clean();
Logger::print($c);


igk_exit();
// $jdsata = json_decode($src = file_get_contents(__DIR__ . "/check.json"));
// $_SERVER['REQUEST_METHOD'] = 'POST';
// $g = Request::getInstance();
// $g->setJsonData($src);
// SwaggerOAuth::Handle($g);
// igk_exit();