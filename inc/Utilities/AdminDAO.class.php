<?php

class AdminDAO{
    private static $_db;

    public static function initialize(){
        self::$_db = new PDOAgent('Admin');
    }

    public static function createAdmin(Admin $newAdmin){
        $sql = "INSERT INTO admin(admin_id, fullname, email, phone, company)
                VALUES(:admin_id, :fullname, :email, :phone, :company);";
        
        self::$_db->query($sql);
        self::$_db->bind(':admin_id', $newAdmin->admin_id);
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

    public static function getAdmin($id){
        $sql = "SELECT * FROM admin 
                WHERE admin_id = :id;";
        self::$_db->query($sql);
        self::$_db->bind(':id', $id);
        self::$_db->execute();
        return self::$_db->singleResult();
    }
    
}