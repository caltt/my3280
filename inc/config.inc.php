<?php

// REST
$lastSlash = strrpos($_SERVER['REQUEST_URI'], '/');
$path = 'http://localhost' . substr($_SERVER['REQUEST_URI'], 0, $lastSlash) . '/RESTapi.php';

define('API_URL', $path);

// define('API_URL', 'http://localhost/cz80php/Final+/RestAPI.php');

// DB
define('DB_HOST', 'localhost');
define('DB_NAME', 'final_plus');
define('DB_USER', 'root');
define('DB_PASS', ''); 