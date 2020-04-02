<?php

class LoginManager
{

    public static function hasLogin(): bool
    {
        if (!isset($_SESSION) && session_id() == ''){
            session_start();
        }

        if (isset($_SESSION['username'])){
            return true;
        }else{
            session_destroy();
            header('Location: login.php');
            return false;
        }
    }
}
