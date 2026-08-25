#!/usr/bin/env php
<?php
/**
 * script that will run after sync-deployment
 */

$installer->rmFiles('/Data/swagger');
$extra_arg = implode(' ', ['--wdir:'.$installer->siteRootDir]);
foreach (
    [ 
        $installer->balafon . ' --db:initdb --controller:' . $installer->projectName,
        $installer->balafon . ' --db:migrate --controller:' . $installer->projectName
    ] as  $cmd) 
    {
    shell_exec("{$cmd} {$extra_arg}2>&1");
} 