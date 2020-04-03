<?php

// config
require_once "inc/config.inc.php";
// entities
require_once "inc/Entities/Job.class.php";
require_once "inc/Entities/Admin.class.php";
require_once "inc/Entities/Employee.class.php";
require_once "inc/Entities/Availability.class.php";
// utilities
require_once "inc/Utilities/PDOAgent.class.php";
require_once "inc/Utilities/JobDAO.class.php";
require_once "inc/Utilities/AdminDAO.class.php";
require_once "inc/Utilities/EmployeeDAO.class.php";
require_once "inc/Utilities/AvailabilityDAO.class.php";
require_once "inc/Utilities/Page.class.php";

// initialize DAOs
JobDAO::initialize();
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

if ($requestData->resource == 'admin') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // check if username exists in admin & employee tables
        $adminUsernames = [];
        $employeeUsernames = [];
        foreach (AdminDAO::getAdmins() as $admin) {
            $adminUsernames[] = $admin->username;
        }
        foreach (EmployeeDAO::getEmployees() as $employee) {
            $employeeUsernames[] = $employee->username;
        }
        if (in_array($requestData->username, $adminUsernames) || in_array($requestData->username, $employeeUsernames)) {
            header('Content-Type: application/json');
            echo json_encode("Username already exists.");
        } else {
            // create admin
            $newAdmin = new Admin();
            $newAdmin->username = $requestData->username;
            $newAdmin->password = $requestData->password;
            $newAdmin->fullname = $requestData->fullname;
            $newAdmin->email = $requestData->email;
            $newAdmin->phone = $requestData->phone;

            $result = AdminDAO::createAdmin($newAdmin);
            header('Content-Type: application/json');
            echo json_encode($result);
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
        // check if username exists in admin & employee tables
        $adminUsernames = [];
        $employeeUsernames = [];
        foreach (AdminDAO::getAdmins() as $admin) {
            $adminUsernames[] = $admin->username;
        }
        foreach (EmployeeDAO::getEmployees() as $employee) {
            $employeeUsernames[] = $employee->username;
        }
        if (in_array($requestData->username, $adminUsernames) || in_array($requestData->username, $employeeUsernames)) {
            header('Content-Type: application/json');
            echo json_encode("Username already exists.");
        } else {
            // create admin
            $newEmployee = new Employee();
            $newEmployee->username = $requestData->username;
            $newEmployee->password = $requestData->password;
            $newEmployee->fullname = $requestData->fullname;
            $newEmployee->email = $requestData->email;
            $newEmployee->phone = $requestData->phone;
            $newEmployee->job_id = $requestData->job_id;
            $newEmployee->manager_id = $requestData->manager_id;
            $result = EmployeeDAO::createEmployee($newEmployee);
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->username)) {
            $employee = EmployeeDAO::getEmployee($requestData->username);
            header('Content-Type: application/json');
            echo json_encode($employee->standardize());
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
            $jobs = JobDAO::getJobs(); // Admin objects

            // convert to json
            $jJobs = [];
            foreach ($jobs as $job) {
                $jJobs[] = $job->standardize();
            }
            // return json array
            header('Content-Type: application/json');
            echo json_encode($jJobs);
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

