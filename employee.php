<?php

require_once "inc/Utilities/LoginManager.class.php";
session_start();

if (!LoginManager::hasLoggedIn() || LoginManager::getRole() != 'employee'){
    header('Location: login.php');
}else{
    echo 'employee homepage';

    var_dump($_SESSION);
}


?>
<!-- test -->
<a href="logout.php" class="btn">Log out</button>