<?php

class Assignment{
    private $assignment_id;
    private $employee_id;
    private $date;
    private $shift_id;

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

    public function standardize(){
        return get_object_vars($this);
    }
}