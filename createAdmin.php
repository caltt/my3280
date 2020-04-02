<?php

require_once "inc/config.inc.php";

require_once "inc/Entities/Admin.class.php";

require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

Page::header();
// AdminDAO::initialize();
if (!empty($_POST) && $_POST['action'] == 'createAdmin'){
    $postData = [
        'resource' => 'admin',  // specify what resource to deal with
        'username' => $_POST['username'],
        'password' => password_hash($_POST['username'], PASSWORD_DEFAULT),
        'fullname' => $_POST['fullname'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'company' => $_POST['company'],
    ];
    
    $result = Rest::call('POST', $postData);
    if (is_numeric($result)){
        Page::notify("Signup successful.");
    }else{
        Page::notify($result);
    }
}

Page::createAdmin();
Page::footer();