<?php

// config
require_once "inc/config.inc.php";
// entities
require_once "inc/Entities/Login.class.php";
require_once "inc/Entities/Job.class.php";
require_once "inc/Entities/Shift.class.php";
require_once "inc/Entities/Admin.class.php";
require_once "inc/Entities/Employee.class.php";
require_once "inc/Entities/Availability.class.php";
// utilities
require_once "inc/Utilities/PDOAgent.class.php";
require_once "inc/Utilities/LoginDAO.class.php";
require_once "inc/Utilities/JobDAO.class.php";
require_once "inc/Utilities/ShiftDAO.class.php";
require_once "inc/Utilities/AdminDAO.class.php";
require_once "inc/Utilities/EmployeeDAO.class.php";
require_once "inc/Utilities/AvailabilityDAO.class.php";
require_once "inc/Utilities/Page.class.php";
 
// initialize DAOs
LoginDAO::initialize();
JobDAO::initialize();
ShiftDAO::initialize();
AdminDAO::initialize();
EmployeeDAO::initialize();
AvailabilityDAO::initialize();

// fetch request data (json) and decode
$requestData = json_decode(file_get_contents('php://input'));

/************************************
 *  steps of handling the request   *
 *  1. check resource name          *
 *  2. check method                 *
 ************************************/

if ($requestData->resource == 'login'){
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->username)) {
            $user = LoginDAO::getUser($requestData->username);
            header('Content-Type: application/json');
            echo json_encode($user->standardize());
        } else {
            // get all
            $users = LoginDAO::getUsers(); // Login objects

            // convert to stdClass obj
            $stdUsers = [];
            foreach ($users as $user) {
                $stdUsers[] = $user->standardize();
            }
            // return json array
            header('Content-Type: application/json');
            echo json_encode($stdUsers);
        }
    }
}

if ($requestData->resource == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // check if username exists in login tables
        $usernames = [];
        foreach (LoginDAO::getUsers() as $user) {
            $usernames[] = $user->username;
        }
        if (in_array($requestData->username, $usernames)) {
            header('Content-Type: application/json');
            echo json_encode("Username already exists.");
        } else {
            // create user login info
            $newUser = new Login();
            $newUser->username = $requestData->username;
            $newUser->password = $requestData->password;
            $newUser->is_admin = $requestData->is_admin;
            $newAdminId = LoginDAO::createUser($newUser);

            // create admin
            $newAdmin = new Admin();
            $newAdmin->admin_id = $newAdminId;
            $newAdmin->fullname = $requestData->fullname;
            $newAdmin->email = $requestData->email;
            $newAdmin->phone = $requestData->phone;
            AdminDAO::createAdmin($newAdmin);

            header('Content-Type: application/json');
            echo json_encode($newAdminId);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->username)) {
            $admin = AdminDAO::getAdmin($requestData->username);
            header('Content-Type: application/json');
            echo json_encode($admin->standardize());
        } else {
            // get all
            $admins = AdminDAO::getAdmins(); // Admin objects

            // convert to json
            $stdAdmins = [];
            foreach ($admins as $admin) {
                $stdAdmins[] = $admin->standardize();
            }
            // return json array
            header('Content-Type: application/json');
            echo json_encode($stdAdmins);
        }
    }
}

if ($requestData->resource == 'employee') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // check if username exists in login tables
        $usernames = [];
        foreach (LoginDAO::getUsers() as $user) {
            $usernames[] = $user->username;
        }
        if (in_array($requestData->username, $usernames)) {
            header('Content-Type: application/json');
            echo json_encode("Username already exists.");
        } else {
            // create user login info
            $newUser = new Login();
            $newUser->username = $requestData->username;
            $newUser->password = $requestData->password;
            $newUser->is_admin = $requestData->is_admin;
            $newEmpId = LoginDAO::createUser($newUser);

            // create admin
            $newEmp = new Employee();
            $newEmp->employee_id = $newEmpId;
            $newEmp->fullname = $requestData->fullname;
            $newEmp->email = $requestData->email;
            $newEmp->phone = $requestData->phone;
            $newEmp->job_id = $requestData ->job_id;
            $newEmp->manager_id = $requestData->manager_id;
            EmployeeDAO::createEmployee($newEmp);

            header('Content-Type: application/json');
            echo json_encode($newEmpId);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single when username is provided
        if (isset($requestData->username)) {
            $employee = EmployeeDAO::getEmployee($requestData->username);
            header('Content-Type: application/json');
            echo json_encode($employee->standardize());
        // get eligible employees for a certain day, job and shift when date is provided (for assigning work)
        } else if (isset($requestData->date)){
            // filter by day and shift (from avilability table)
            // $availableEmployees = AvailabilityDAO::
            // then job (from job table)
            // $employees = EmployeeDAO::getAvailableEmployees($requestData->date, $requestData->shift, $requestData->)
        } else {
            // get all
            $employees = AdminDAO::getEmployees(); // Admin objects

            // convert to json
            $stdEmployees = [];
            foreach ($$employees as $$employee) {
                $stdEmployees[] = $$employee->standardize();
            }
            // return json array
            header('Content-Type: application/json');
            echo json_encode($stdEmployees);
        }
    }
}

if ($requestData->resource == 'job') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->job_id)) {

        } else {
            // get all
            $jobs = JobDAO::getJobs(); 

            // convert to stdClass obj
            $sJobs = [];
            foreach ($jobs as $job) {
                $sJobs[] = $job->standardize();
            }
            // return json array
            header('Content-Type: application/json');
            echo json_encode($sJobs);
        }
    }
}

if ($requestData->resource == 'shift') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->shift_id)) {

        } else {
            // get all
            $shifts = ShiftDAO::getShifts(); 

            $sShifts = [];
            foreach ($shifts as $shift) {
                $sShifts[] = $shift->standardize();
            }
            // return json array
            header('Content-Type: application/json');
            echo json_encode($sShifts);
        }
    }
}

if ($requestData->resource == 'availability') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newAva = new Availability();
        $newAva->employee_id = $requestData->employee_id;
        $newAva->day_id = $requestData->day_id;
        $newAva->shift_id = $requestData->shift_id;
        $result = AvailabilityDAO::createAvailability($newAva);
        header('Content-Type: application/json');
        echo json_encode($result);
    }
}

if ($requestData->resource == 'user') {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->username)) {
            $employee = EmployeeDAO::getEmployee($requestData->username);
            header('Content-Type: application/json');
            echo json_encode($employee->standardize());
        } else {
            // // get all
            // $jobs = JobDAO::getJobs(); // Admin objects

            // // convert to json
            // $jJobs = [];
            // foreach ($jobs as $job) {
            //     $jJobs[] = $job->standardize();
            // }
            // // return json array
            // header('Content-Type: application/json');
            // echo json_encode($jJobs);
        }
    }
}

