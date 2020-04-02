<?php

class Employee{
    private $employee_id;
    private $username;
    private $password;
    private $fullname;
    private $phone;
    private $email;
    private $job_id;
    private $manager_id;

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
}