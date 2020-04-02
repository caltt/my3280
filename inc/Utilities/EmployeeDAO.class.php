<?php

class EmployeeDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Employee');
    }

    public static function createEmployee(Employee $newEmp){
        $sql = "INSERT INTO employee(username, password, fullname, email, phone, job_id, manager_id)
                VALUES(:username, :password, :fullname, :email, :phone, :jobid, :managerid);";
        
        self::$_db->query($sql);
        self::$_db->bind(':username', $newEmp->username);
        self::$_db->bind(':password', $newEmp->password);
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

    private static function validate(){

    }
}