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

    public static function createJob($job){
        $sql = "INSERT INTO job(job_title) 
                VALUES (:jobtitle);";
        self::$_db->query($sql);
        self::$_db->bind(':jobtitle', $job->job_title);
        self::$_db->execute();
        return self::$_db->lastInsertedId();
    }
}