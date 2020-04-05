<?php

class ShiftDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Shift');
    }

    public static function getShifts(){
        $sql = "SELECT * FROM shift;";
        self::$_db->query($sql);
        self::$_db->execute();
        return self::$_db->resultSet();
    }
}