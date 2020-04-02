<?php

class AvailabilityDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Availability');
    }

    public static function createAvailability(Availability $a){
        $sql = "INSERT INTO availability
                VALUES(:employeeid, :dayid, :shiftid);";
        
        self::$_db->query($sql);
        self::$_db->bind(':employeeid', $a->employee_id);
        self::$_db->bind(':dayid', $a->day_id);
        self::$_db->bind(':shiftid', $a->shift_id);
        self::$_db->execute();
        return self::$_db->lastInsertedId();
    }
}