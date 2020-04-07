<?php

class User{
    private $user_id;
    private $username;
    private $password;
    private $is_admin;

    public function __get($propName){
        if (property_exists(get_class($this), $propName)){
            return $this->$propName;
        }
    }

    public function __set($propName, $value){
        if (property_exists(get_class($this), $propName)){
            $this->$propName = $value;
        }
    }
    
    public function verifyPassword($inputtedPassword){
        return password_verify($inputtedPassword, $this->password);
    }

    public function standardize(){
        return get_object_vars($this);
    }
}