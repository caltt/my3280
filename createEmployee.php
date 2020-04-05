<?php
// config
require_once "inc/config.inc.php";

require_once "inc/Utilities/LoginManager.class.php";
require_once "inc/Utilities/Rest.class.php";
require_once "inc/Utilities/Page.class.php";

session_start();

var_dump($_SESSION);

Page::header();

if (!LoginManager::hasLoggedIn() || LoginManager::getRole() != 'admin'){
    header('Location: login.php');
}

if (!empty($_POST) && $_POST['action'] == 'createEmployee') {

    // create ONE new row in employee table
    $postDataEmployee = [
        'resource' => 'employee', // specify what resource to deal with
        'username' => $_POST['username'],
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'is_admin' => 0,
        'fullname' => $_POST['fullname'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'job_id' => $_POST['job_id'],
        'manager_id' => $_SESSION['admin_id'],
    ];

    $resultEmployee = Rest::call('POST', $postDataEmployee);

    // create MULTIPLE rows in availability table
    $checkedShifts = array_keys($_POST, 'checked'); // get name of all checked checkboxes

    // build postData for each availability row
    foreach ($checkedShifts as $checkedShift) {
        $postDataAvailability = [
            'resource' => 'availability',
            'employee_id' => $resultEmployee,   // employee_id was returned from call()
            'day_id' => substr($checkedShift, 0, 1),    // first char of name is exactly day_id
            'shift_id' => substr($checkedShift, 1, 1)   // second char is shift_id
        ];

        $resultAvailability = Rest::call('POST', $postDataAvailability);
    }
    var_dump($resultEmployee);
    if (is_numeric($resultEmployee)){
        Page::notify("Employee $resultEmployee Created.");
    }else{
        Page::notify("Username already exists.");
    }

}

// get all jobs for the job dropdown list
$sJobs = Rest::call('GET', [ 'resource' => 'job', ]);    // stdClass objs

Page::createEmployee($sJobs);
Page::footer();
