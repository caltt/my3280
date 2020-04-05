<?php

require_once "inc/config.inc.php";

require_once "inc/Utilities/LoginManager.class.php";
require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

$sJobs = Rest::call('GET', [ 'resource' => 'job' ]);
$sShifts = Rest::call('GET', [ 'resource' => 'shift' ]);


Page::header();
Page::assign($sJobs, $sShifts);
Page::footer();