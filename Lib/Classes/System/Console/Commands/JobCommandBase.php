<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobCommandBase.php
// @date: 20250822 07:21:19
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use IGK\System\Console\AppExecCommand;
/**
* 
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
abstract class JobCommandBase extends AppExecCommand{
    var $category = 'forem-job';
    var $usage = '[options]';
    var $desc = '';
}