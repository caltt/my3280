<?php

class Admin{
    private $admin_id;
    private $username;
    private $password;
    private $fullname;
    private $phone;
    private $email;
    private $company;

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

    public function jsonSerialize(){
        return get_object_vars($this);
    }
}