<?php

class JobDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Job');
    }

    public static function getJobs(){
        $sql = "SELECT * FROM job;";
        self::$_db->query($sql);
        self::$_db->execute();
        return self::$_db->resultSet();
    }
}