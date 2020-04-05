<?php

require_once "inc/config.inc.php";

require_once "inc/Entities/Login.class.php";
require_once "inc/Entities/Admin.class.php";
require_once "inc/Entities/Employee.class.php";

require_once "inc/Utilities/LoginManager.class.php";
require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

var_dump($_SESSION);
// var_dump($_SERVER);

// if has already logged in
if (LoginManager::hasLoggedIn()){
    if (LoginManager::getRole() == 'admin'){
        header('Location: admin.php');
    }
    if (LoginManager::getRole() == 'employee'){
        header('Location: employee.php');
    }
}

// check if username in admin or employee table
if (!empty($_POST['username'])) {
    $requestData = [
        'resource' => 'login',
        'username' => $_POST['username'],
    ];
    $matchedUser = Rest::call('GET', $requestData);
    if ($matchedUser){
        $authUser = new Login();
        $authUser->user_id = $matchedUser->user_id;
        $authUser->username = $matchedUser->username;
        $authUser->password = $matchedUser->password;
        $authUser->is_admin = $matchedUser->is_admin;
    }

    var_dump($authUser);
    // if yes
    if (isset($authUser)) {
        // verify password
        if ($authUser->verifyPassword($_POST['password'])) {
            session_start();
            $_SESSION['username'] = $_POST['username'];
            if ($authUser->is_admin) {
                $_SESSION['role'] = 'admin';
                $_SESSION['admin_id'] = $authUser->user_id;
                header('Location: admin.php');
            } else {
                $_SESSION['role'] = 'employee';
                $_SESSION['employee_id'] = $authUser->user_id;
                header('Location: employee.php');
            }
        } else {
            Page::notify('Invalid username/password.');
        }
    }

}
Page::header();
Page::login();
Page::footer();
