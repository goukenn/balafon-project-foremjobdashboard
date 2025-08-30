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
* 
* @package com\igkdev\projects\ForemJobDashboard\System\Console\Commands
* @author C.A.D. BONDJE DOUE
*/
class JobFollowCommand extends JobCommandBase{
	var $command='--forem-job:follow';
	var $desc='view jobs follows list';
	var $options=[
		'--user:[id]'=>'user id'
	];
	var $category = '';
	var $usage = '[options]';
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