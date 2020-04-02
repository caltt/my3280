<?php

require_once "inc/config.inc.php";

require_once "inc/Entities/Admin.class.php";
require_once "inc/Entities/Employee.class.php";

require_once "inc/Utilities/PDOAgent.class.php";
require_once "inc/Utilities/AdminDAO.class.php";
require_once "inc/Utilities/EmployeeDAO.class.php";
require_once "inc/Utilities/Page.class.php";

session_start();

if(isset($_POST)){
    AdminDAO::initialize();
    EmployeeDAO::initialize();

    
}
Page::header();
Page::login();
Page::footer();