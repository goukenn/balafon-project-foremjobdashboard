<?php
// @author: C.A.D. BONDJE DOUE
// @file: JobUtilityTest.php
// @date: 20260910 09:19:46
namespace com\igkdev\projects\ForemJobDashboard\Tests\Helpers;

use com\igkdev\projects\ForemJobDashboard\Helpers\JobUtility;
use IGK\Tests\BaseTestCase; 

/**
* 
* @package com\igkdev\projects\ForemJobDashboard\Tests\Helpers
* @author C.A.D. BONDJE DOUE
*/
class JobUtilityTest extends BaseTestCase{
    public function test_jobutility(){
        $p = JobUtility::CreateJobIdentify('IT DEV', 'igkdev');
        $this->assertEquals('e007e31f', $p);
    }
}