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

Page::header();

JobDAO::initialize();
AdminDAO::initialize();
EmployeeDAO::initialize();
AvailabilityDAO::initialize();

if (!empty($_POST['username'])) { // MOD
    try {
        // check if username exists in admin & employee tables
        $adminUsernames = [];
        $employeeUsernames = [];
        foreach (AdminDAO::getAdmins() as $admin) {
            $adminUsernames[] = $admin->username;
        }
        foreach (EmployeeDAO::getEmployees() as $employee) {
            $employeeUsernames[] = $employee->username;
        }
        if (in_array($_POST['username'], $adminUsernames) || in_array($_POST['username'], $employeeUsernames)) {
            throw new Exception('Username already exists.');
        }

        // if not exists, create new employee
        $newEmployee = new Employee();
        $newEmployee->username = $_POST['username'];
        $newEmployee->fullname = $_POST['fullname'];
        $newEmployee->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $newEmployee->email = $_POST['email'];
        $newEmployee->phone = $_POST['phone'];
        $newEmployee->job_id = $_POST['job_id'];
        $newEmployee->manager_id = $_SESSION['admin_id'];
        $result = EmployeeDAO::createEmployee($newEmployee);

        $checkedShifts = array_keys($_POST, 'checked');
        foreach ($checkedShifts as $checkedShift) {
            $availability = new Availability();
            $availability->employee_id = $result; // last insert id
            $availability->day_id = substr($checkedShift, 0, 1);
            $availability->shift_id = substr($checkedShift, 1, 1);
            AvailabilityDAO::createAvailability($availability);
        }

        if (!empty($result)) {
            Page::notify($result);
        }
    } catch (Exception $ex) {
        Page::notify($ex->getMessage());
    }

}

// if?

Page::createEmployee(JobDAO::getJobs());
Page::footer();
