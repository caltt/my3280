<?php

class AdminDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Admin');
    }

    public static function createAdmin(Admin $newAdmin){
        $sql = "INSERT INTO admin(username, password, fullname, email, phone, company)
                VALUES(:username, :password, :fullname, :email, :phone, :company);";
        
        self::$_db->query($sql);
        self::$_db->bind(':username', $newAdmin->username);
        self::$_db->bind(':password', $newAdmin->password);
        self::$_db->bind(':fullname', $newAdmin->fullname);
        self::$_db->bind(':email', $newAdmin->email);
        self::$_db->bind(':phone', $newAdmin->phone);
        self::$_db->bind(':company', $newAdmin->company);
        // check if admin username exists
        try{
            self::$_db->execute();
        }catch (PDOException $pe){
            return $pe->getMessage();
        }
        return self::$_db->lastInsertedId();
    }

    public static function getAdmins(){
        $sql = "SELECT * FROM admin;";
        self::$_db->query($sql);
        self::$_db->execute();
        return self::$_db->resultSet();
    }

    public static function getAdmin($adminUsername){
        $sql = "SELECT * FROM admin WHERE username = :username;";
        self::$_db->query($sql);
        self::$_db->bind(':username', $adminUsername);
        self::$_db->execute();
        return self::$_db->singleResult();
    }
    
}