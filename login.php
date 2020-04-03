<?php

require_once "inc/config.inc.php";

require_once "inc/Entities/Admin.class.php";
require_once "inc/Entities/Employee.class.php";

require_once "inc/Utilities/LoginManager.class.php";
require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

session_start();

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
        'username' => $_POST['username'],
    ];
    $results = [];
    // $temp = Rest::call('GET', ['resource' => 'admin']);
    // var_dump($temp);
    $resultAdmin = Rest::call('GET', array_merge($requestData, ['resource' => 'admin']));
    $resultEmployee = Rest::call('GET', array_merge($requestData, ['resource' => 'employee']));
    // var_dump($resultAdmin);
    if ($resultAdmin){
        $authUser = new Admin();
        $authUser->admin_id = $resultAdmin->admin_id;
        $authUser->username = $resultAdmin->username;
        $authUser->password = $resultAdmin->password;
    }
    if ($resultEmployee){
        $authUser = new Employee();
        $authUser->employee_id = $resultEmployee->employe_id;
        $authUser->username = $resultEmployee->username;
        $authUser->password = $resultEmployee->password;
    }


    // if yes
    if (isset($authUser)) {
        // verify password
        if ($authUser->verifyPassword($_POST['password'])) {
            session_start();
            $_SESSION['username'] = $_POST['username'];
            if (is_a($authUser, 'Admin')) {
                $_SESSION['role'] = 'admin';
                $_SESSION['admin_id'] = $authUser->admin_id;
                header('Location: admin.php');
            } else {
                $_SESSION['role'] = 'employee';
                $_SESSION['admin_id'] = $authUser->employee_id;
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
