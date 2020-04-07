<?php

// config
require_once "inc/config.inc.php";
// entities
require_once "inc/Entities/User.class.php";
require_once "inc/Entities/Job.class.php";
require_once "inc/Entities/Shift.class.php";
require_once "inc/Entities/Admin.class.php";
require_once "inc/Entities/Employee.class.php";
require_once "inc/Entities/Availability.class.php";
require_once "inc/Entities/Assignment.class.php";
// utilities
require_once "inc/Utilities/PDOAgent.class.php";
require_once "inc/Utilities/UserDAO.class.php";
require_once "inc/Utilities/JobDAO.class.php";
require_once "inc/Utilities/ShiftDAO.class.php";
require_once "inc/Utilities/AdminDAO.class.php";
require_once "inc/Utilities/EmployeeDAO.class.php";
require_once "inc/Utilities/AvailabilityDAO.class.php";
require_once "inc/Utilities/AssignmentDAO.class.php";
require_once "inc/Utilities/Page.class.php";

 
// initialize DAOs
UserDAO::initialize();
JobDAO::initialize();
ShiftDAO::initialize();
AdminDAO::initialize();
EmployeeDAO::initialize();
AvailabilityDAO::initialize();
AssignmentDAO::initialize();

// fetch request data (json) and decode
$requestData = json_decode(file_get_contents('php://input'));

/************************************
 *  steps of handling the request   *
 *  1. check resource name          *
 *  2. check method                 *
 ************************************/

if ($requestData->resource == 'user'){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newUser = new User();
        $newUser->username = $requestData->username;
        $newUser->password = $requestData->password;
        $newUser->is_admin = $requestData->is_admin;
        $result = UserDAO::createUser($newUser);

        header('Content-Type: application/json');
        echo json_encode($result);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->username)) {
            $user = UserDAO::getUser($requestData->username);
            header('Content-Type: application/json');
            if (is_a($user, 'User')){
                echo json_encode($user->standardize());
            }else{
                echo json_encode('');
            }
            
        } else {
            // get all
            $users = UserDAO::getUsers(); // User objects

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
        // create admin
        $newAdmin = new Admin();
        $newAdmin->admin_id = $requestData->admin_id;
        $newAdmin->fullname = $requestData->fullname;
        $newAdmin->email = $requestData->email;
        $newAdmin->phone = $requestData->phone;
        $result = AdminDAO::createAdmin($newAdmin);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // get single
        if (isset($requestData->admin_id)) {
            $admin = AdminDAO::getAdmin($requestData->admin_id);
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

        $newEmp = new Employee();
        $newEmp->employee_id = $requestData->employee_id;
        $newEmp->fullname = $requestData->fullname;
        $newEmp->email = $requestData->email;
        $newEmp->phone = $requestData->phone;
        $newEmp->job_id = $requestData ->job_id;
        $newEmp->manager_id = $requestData->manager_id;
        $result = EmployeeDAO::createEmployee($newEmp);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        // get single when username is provided
        if (isset($requestData->username)) {
            $employee = EmployeeDAO::getEmployee($requestData->username);
            header('Content-Type: application/json');
            echo json_encode($employee->standardize());

        // get eligible employees for a certain day, job and shift when date is provided (for assigning work)
        } else if (isset($requestData->date) && 
                    isset($requestData->shift_id) && 
                    isset($requestData->day_id) &&
                    isset($requestData->manager_id)) {

            $empsDayShift = AvailabilityDAO::getEmployeesAvailable($requestData->day_id, $requestData->shift_id);
            $empsManager = EmployeeDAO::getEmployeesByManager($requestData->manager_id);
            $empsDate = AssignmentDAO::getEmployeesAssigned($requestData->date, $requestData->shift_id);
                        
            // different objs
            // but they all have emp_id
            // fetch emp_id
            $e1 = [];
            $e2 = [];
            $e3 = [];
            $employees = [];
            
            foreach ($empsDayShift as $e){
                $e1[] = $e->employee_id;
            }
            foreach ($empsManager as $e){
                $e2[] = $e->employee_id;
            }
            foreach ($empsDate as $e){
                $e3[] = $e->employee_id;
            }

            // e1 intersects e2 and then exclude e3
            $empIds = array_diff(array_intersect($e1, $e2), $e3);

            // get Employee objs by id then convert to stdClass objs
            foreach ($empIds as $empId){
                $sEmployees[] = EmployeeDAO::getEmployee($empId)->standardize();
            }

            header('Content-Type: application/json');
            echo json_encode($sEmployees);
            
        // get all
        } else if (isset($requestData->manager_id)){
            $employees = EmployeeDAO::getEmployeesByManager($requestData->manager_id);
            $sEmployees = [];
            foreach ($employees as $employee){
                $sEmployees[] = $employee->standardize();
            }
            header('Content-Type: application/json');
            echo json_encode($sEmployees);

        // query in availability & assignment to get available employees
        } else{
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

if ($requestData->resource == 'assignment') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $newAs = new Assignment();
        $newAs->employee_id = $requestData->employee_id;
        $newAs->date = $requestData->date;
        $newAs->shift_id = $requestData->shift_id;
        $result = AssignmentDAO::createAssignment($newAs);
        header('Content-Type: application/json');
        echo json_encode($result);
    }

}