<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobFollowCommand.php
// @date: 20250825 15:21:13
namespace com\igkdev\projects\ForemJobDashboard\System\Console\Commands;
use com\igkdev\projects\ForemJobDashboard\Database\Utility as DatabaseUtility;
use com\igkdev\projects\ForemJobDashboard\UserConfigSetting;
use ForemJobDashboardController;
use IGK\System\Console\AppExecCommand;
use IGK\System\Console\Commands\DbCommandHelper;
use IGK\System\Console\Commands\ServerCommandHelper;
use igk\System\Console\Commands\Utility;

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/

/**
* auto generate doc.
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
*/
class JobFollowCommand extends JobCommandBase{

    /**
    * auto generate doc.
    * @var mixed
    */
    var $command='--forem-job:follow';

    /**
    * auto generate doc.
    * @var mixed
    */
    var $desc='view jobs follows list';

    /**
    * auto generate doc.
    * @var mixed
    */
    var $options=[
		'--user:[id]'=>'user id'
	];

    /**
    * auto generate doc.
    * @var mixed
    */
    var $category = 'forem';

    /**
    * auto generate doc.
    * @var mixed
    */
    var $usage = '[options]';

    /**
    * auto generate doc.
    * @param mixed $command
    */
    public function exec($command) { 
		$ctrl = ForemJobDashboardController::ctrl(true);
		self::BindUserCommand($ctrl, $command);
		DbCommandHelper::Init($command);
        ServerCommandHelper::Init($command);
		$user = $ctrl->getUserProfile() ?? igk_die('missing user');  
		$tr = UserConfigSetting::DbUserSetting($user);
		$tr->followDate = '+2 week';
		$tr->phone = '32486684697';
		$tr->email = 'cbondje@igkdev.com';
		$tr->title = 'PHP / .NET Analyst DEVELOPER';
		$tr->address = 'Place Grande Pêcherie 8, 7000 Mons';
		$tr->linkedin = 'https://www.linkedin.com/in/bondjedoue';
		$tr->facebook = 'https://www.facebook.com/bondjesonde';
		$tr->x = 'https://x.com/IGKDEV';
		$tr->locale = 'fr';
		$tr->firstName = 'Charles';
		$tr->lastName = 'BONDJE DOUE';
		$tr->drivingLicenses = 'B';
		$tr->skills = ['PHP', 'CSS', 'HTML', 'Javascript', 'WebDev', 'DevOps', 'GIT', 'DOCKER', 'Virtualization', 'AI'];
		$tr->store();
		$r = DatabaseUtility::GetUserSetting($user, 'followDate');
		igk_wln_e('users :: ', $r);
	}
}