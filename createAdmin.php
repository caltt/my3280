<?php

require_once "inc/config.inc.php";

require_once "inc/Utilities/LoginManager.class.php";
require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

Page::header();
Page::navBar();

// doesn't need to login

$errMsg = '';

if (!empty($_POST) && $_POST['action'] == 'createAdmin' && isset($_POST['username'])){

    // check if passwords match
    if ($_POST['password'] !== $_POST['password2']){
        $errMsg = 'Passwords do not match.';
    }

    // check if username already exists
    $data = [
        'resource' => 'user',
        'username' => $_POST['username']
    ];

    $sUser = Rest::call('GET', $data);  // std objs
    if (is_null($sUser)){
        $errMsg = 'Username already exist.';
    }
    
    // everything OK
    if ($errMsg === ''){
        $data = [
            'resource' => 'user', 
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'is_admin' => 1,
        ];
        
        $insertId = Rest::call('POST', $data);

        $data = [
            'resource' => 'admin',
            'admin_id' => $insertId,
            'fullname' => $_POST['fullname'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'company' => $_POST['company'],
        ];

        Rest::call('POST', $data);
        // var_dump($errMsg);
        // var_dump($result);
        if (is_numeric($insertId)){
            Page::notify("Admin {$_POST['username']} Signup successful.");
        }else{
            Page::notify($errMsg);
        }
    }
}

Page::createAdmin();
Page::footer();