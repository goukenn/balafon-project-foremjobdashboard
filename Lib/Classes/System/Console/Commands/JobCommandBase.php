<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobCommandBase.php
// @date: 20250822 07:21:19
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use IGK\System\Console\AppExecCommand;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
*/
abstract class JobCommandBase extends AppExecCommand{
    /**
    * auto generate doc.
    * @var mixed
    */
    var $category = 'forem-job';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $usage = '[options]';
    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc = '';
}