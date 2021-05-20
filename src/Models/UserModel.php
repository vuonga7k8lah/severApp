<?php


namespace severApp\Models;


use severApp\Database\DB;

class UserModel
{
    public static function isUserExist($userName)
    {
        return !empty(self::getID($userName)) ? true : false;
    }
    public static function isUserAdmin($userName)
    {
        $query=DB::makeConnection()->query("SELECT * FROM users WHERE userName='" . $userName . "' AND level=3 ")
            ->fetch_assoc();
        return !empty($query) ? true : false;
    }

    public static function getID($userName)
    {
        $ID = DB::makeConnection()->query("SELECT ID FROM users WHERE userName='" . $userName . "'")->fetch_assoc();
        return (!empty($ID)) ? $ID['ID'] : 0;
    }

    public static function insert($aData)
    {
        $sql
            = "INSERT INTO `users`(`ID`, `HoTen`, `userName`, `password`, `NgaySinh`, `CMT`, `DiaChi`, `level`, `token`, `createDate`) VALUES (null,'" .
            $aData['HoTen'] . "','" . $aData['username'] . "','" . $aData['password'] . "','" . $aData['NgaySinh'] .
            "','" . $aData['CMT'] . "','" . $aData['DiaChi'] . "',1,'',null)";
        $insert = DB::makeConnection()
            ->query($sql);
        if ($insert) {
            return self::getID($aData['username']);
        }
        return 0;
    }

    public static function updateToken($id, $token)
    {
        return DB::makeConnection()->query("UPDATE  users SET token='" . $token . "' WHERE ID='" . $id . "'");
    }

    public static function getAllUser(): ?array
    {
        return DB::makeConnection()->query("SELECT * FROM users")->fetch_all();
    }
}