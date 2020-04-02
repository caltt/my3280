<?php

require_once "inc/config.inc.php";

require_once "inc/Entities/Admin.class.php";

require_once "inc/Utilities/PDOAgent.class.php";
require_once "inc/Utilities/AdminDAO.class.php";
require_once "inc/Utilities/Page.class.php";

Page::header();

AdminDAO::initialize();
if (!empty($_POST['username'])){
    $newAdmin = new Admin();
    $newAdmin->username = $_POST['username'];
    $newAdmin->fullname = $_POST['fullname'];
    $newAdmin->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $newAdmin->email = $_POST['email'];
    $newAdmin->phone = $_POST['phone'];
    $newAdmin->company = $_POST['company'];
    $result = AdminDAO::createAdmin($newAdmin);
    if (!empty($result)){
        Page::notify($result);
    }
}

Page::signup();
Page::footer();