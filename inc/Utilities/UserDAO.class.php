<?php

class UserDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('User');
    }

    public static function createUser(User $newUser){
        $sql = "INSERT INTO user(username, password, is_admin)
                VALUES(:username, :password, :isadmin);";
        
        self::$_db->query($sql);
        self::$_db->bind(':username', $newUser->username);
        self::$_db->bind(':password', $newUser->password);
        self::$_db->bind(':isadmin', $newUser->is_admin);
        self::$_db->execute();
        return self::$_db->lastInsertedId();
    }

    public static function getUsers(){
        $sql = "SELECT * FROM user;";
        self::$_db->query($sql);
        self::$_db->execute();
        return self::$_db->resultSet();
    }

    public static function getUser($username){
        $sql = "SELECT * FROM user 
                WHERE username = :username;";
        self::$_db->query($sql);
        self::$_db->bind(':username', $username);
        self::$_db->execute();
        return self::$_db->singleResult();
    }
}