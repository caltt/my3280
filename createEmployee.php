<?php
// config
require_once "inc/config.inc.php";

require_once "inc/Utilities/LoginManager.class.php";
require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

session_start();

var_dump($_SESSION);

Page::header();
Page::navBar();

if (!LoginManager::verifyLogin() || LoginManager::getRole() != 'admin'){
    header('Location: login.php');
}

if (!empty($_POST) && $_POST['action'] == 'createEmployee') {

    // check if username already exists
    $data = [
        'resource' => 'user',
        'username' => $_POST['username'],
    ];

    $sUsers = Rest::call('GET', $data);  // std objs

    if (!is_null($sUsers)){

        // 1. insert to login table
        $data = [
            'resource' => 'user', 
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'is_admin' => 0,
        ];  
        $insertId = Rest::call('POST', $data);
    
        // 2. insert to employee table
        $data = [
            'resource' => 'employee', // specify what resource to deal with
            'employee_id' => $insertId,
            'fullname' => $_POST['fullname'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'job_id' => $_POST['job_id'],
            'manager_id' => $_SESSION['admin_id'],
        ];
        Rest::call('POST', $data);

        // 3. insert to availability table
        
        // create MULTIPLE rows in availability table
        $checkedShifts = array_keys($_POST, 'checked'); // get name of all checked checkboxes
        
        // build postData for each availability row
        foreach ($checkedShifts as $checkedShift) {
            $data = [
                'resource' => 'availability',
                'employee_id' => $insertId,   // employee_id was returned from call()
                'day_id' => substr($checkedShift, 0, 1),    // first char of name is exactly day_id
                'shift_id' => substr($checkedShift, 1, 1)   // second char is shift_id
            ];
            
            $resultAvailability = Rest::call('POST', $data);
        }

        if (is_numeric($insertId)){
            Page::notify("Employee $insertId Created.");
        }else{
            Page::notify("Username already exists.");
        }
    }

}

// get all jobs for the job dropdown list
$sJobs = Rest::call('GET', [ 'resource' => 'job', ]);    // stdClass objs

Page::createEmployee($sJobs);
Page::footer();
