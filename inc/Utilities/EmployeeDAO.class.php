<?php

class EmployeeDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Employee');
    }

    public static function createEmployee(Employee $newEmp){
        $sql = "INSERT INTO employee(employee_id, fullname, email, phone, job_id, manager_id)
                VALUES(:employee_id, :fullname, :email, :phone, :jobid, :managerid);";
        
        self::$_db->query($sql);
        self::$_db->bind(':employee_id', $newEmp->employee_id);
        self::$_db->bind(':fullname', $newEmp->fullname);
        self::$_db->bind(':email', $newEmp->email);
        self::$_db->bind(':phone', $newEmp->phone);
        self::$_db->bind(':jobid', $newEmp->job_id);
        self::$_db->bind(':managerid', $newEmp->manager_id);
        self::$_db->execute();
        return self::$_db->lastInsertedId();
    }

    public static function getEmployees(){
        $sql = "SELECT * FROM employee;";
        self::$_db->query($sql);
        self::$_db->execute();
        return self::$_db->resultSet();
    }

    public static function getEmployee($id){
        $sql = "SELECT * FROM employee WHERE employee_id = :emp_id;";
        self::$_db->query($sql);
        self::$_db->bind(':emp_id', $id);
        self::$_db->execute();
        return self::$_db->singleResult();
    }

    // get all employees created by a certain admin
    public static function getEmployeesByManager($managerId){
        $sql = "SELECT * FROM employee WHERE manager_id = :manager_id;";
        self::$_db->bind(':manager_id', $managerId);
        self::$_db->execute();
        return self::$_db->resultSet();
    }

    public static function getEmployeesByAvailability(){
        
    }
    
    private static function validate(){

    }
}