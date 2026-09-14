<?php
if (!function_exists('igk_autoload_test')){
    require_once $_ENV['IGK_APP_DIR'].'/Lib/igk/igk_framework.php';
}
require_once igk_autoload_test('IGK_APP_DIR') . "/Lib/igk/Lib/Tests/autoload.php";
