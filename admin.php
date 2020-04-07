<?php

require_once "inc/config.inc.php";

require_once "inc/Utilities/LoginManager.class.php";
require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

session_start();

Page::header();
Page::navBar();

if (!LoginManager::verifyLogin() || LoginManager::getRole() != 'admin'){
    header('Location: login.php');
}else{
    $data = [ 
        'resource' => 'admin', 
        'admin_id' => $_SESSION['admin_id'],
    ];
    $admin = Rest::call('GET', $data);
    // var_dump($admin);
    $data = [ 
        'resource' => 'employee',
    ];
    $employees = Rest::call('GET', $data);
    Page::adminCalendar($admin, null);
    // var_dump($_SESSION);
}

Page::footer();

?>