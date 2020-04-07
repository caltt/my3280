<?php

require_once "inc/Utilities/LoginManager.class.php";

if (LoginManager::verifyLogin()) {
    session_destroy();
}
    header('Refresh:1; URL=login.php');
    echo 'You have logged out. You will be redirected to login page in 1 seconds.';
