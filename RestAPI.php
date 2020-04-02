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

// handle the request

// check uri
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
        if (isset($requestData->admin_id)) {

        } else {
            // get all
            $admins = AdminDAO::getAdmins(); // Admin objects

            // convert to json
            $jAdmins = [];
            foreach ($admins as $admin) {
                $jAdmins[] = $admin->jsonSerialize();
            }
            // return json array
            header('Content-Type: application/json');
            echo json_encode($jAdmins);
        }
    }
}

if ($requestData->resource == 'employee') {

}
