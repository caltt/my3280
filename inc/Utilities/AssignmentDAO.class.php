<?php

class AssignmentDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Assignment');
    }

    public static function getAssignments(){
        $sql = "SELECT * FROM assignment;";
        
        self::$_db->query($sql);
        self::$_db->execute();
        return self::$_db->resultSet();
    }

    
    public static function createAssignment(Assignment $a){
        $sql = "INSERT INTO assignment(employee_id, date, shift_id)
                VALUES(:employeeid, :date, :shiftid);";
        
        self::$_db->query($sql);
        self::$_db->bind(':employeeid', $a->employee_id);
        self::$_db->bind(':date', $a->date);
        self::$_db->bind(':shiftid', $a->shift_id);
        self::$_db->execute();
        return self::$_db->lastInsertedId();
    }

    public static function getEmployeesAssigned($date, $shift){
        $sql = "SELECT * FROM assignment 
                WHERE date = :date AND shift_id = :shift;";
        self::$_db->query($sql);
        self::$_db->bind(':date', $date);
        self::$_db->bind(':shift', $shift);
        self::$_db->execute();
        return self::$_db->resultSet();
    }

}