<?php


namespace severApp\Models;


use severApp\Database\DB;

class UserModel
{
    public static function isUserExist($userName)
    {
        return !empty(self::getID($userName)) ? true : false;
    }

    public static function getID($userName)
    {
        $ID = DB::makeConnection()->query("SELECT ID FROM users WHERE userName='" . $userName . "'")->fetch_assoc();
        return (!empty($ID)) ? $ID['ID'] : 0;
    }

    public static function isUserAdmin($userName):bool
    {
        $query = DB::makeConnection()->query("SELECT * FROM users WHERE userName='" . $userName . "' AND level=2 ")
            ->fetch_assoc();
        return !empty($query) ? true : false;
    }

    public static function insert($aData)
    {
        $sql
            = "INSERT INTO `users`(`ID`, `HoTen`, `userName`, `password`, `NgaySinh`, `CMT`, `DiaChi`, `level`, `token`, `createDate`) VALUES (null,'" .
            $aData['HoTen'] . "','" . $aData['username'] . "','" . $aData['password'] . "','" . $aData['NgaySinh'] .
            "'," . $aData['CMT'] . ",'" . $aData['DiaChi'] . "',1,'',null)";
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

    public static function update($id, $aData)
    {
        $query = [];
        if ($aData['HoTen'] ?? '') {
            $query[] = " HoTen ='" . $aData['HoTen'] . "'";
        }
        if ($aData['password'] ?? '') {
            $query [] = " password ='" . $aData['password'] . "'";
        }
        if ($aData['NgaySinh'] ?? '') {
            $query [] = " NgaySinh = '" . $aData['NgaySinh'] . "'";
        }
        if ($aData['CMT'] ?? '') {
            $query [] = " CMT = '" . $aData['CMT'] . "'";
        }
        if ($aData['DiaChi'] ?? '') {
            $query [] = " DiaChi = '" . $aData['DiaChi'] . "'";
        }
        if ($aData['role'] ?? '') {
            $query [] = " level = '" . $aData['role'] . "'";
        }
        return DB::makeConnection()->query("UPDATE `users` SET " . implode(',', $query) .
            ",`createDate`=null WHERE ID='" .
            $id . "'");
    }

    public static function delete($ID)
    {
        return DB::makeConnection()->query("DELETE FROM `users` WHERE ID='" . $ID . "'");
    }

    public static function handleLogin($aData)
    {
        $sql = "SELECT ID FROM users WHERE userName='" .
            DB::makeConnection()->real_escape_string($aData['username']) . "' AND password='"
            . DB::makeConnection()->real_escape_string(md5($aData['password'])) . "'";
        $status = DB::makeConnection()->query($sql);
        return (!empty($status)) ? ($status->fetch_assoc())['ID'] : $status;
    }

    public static function getTokenWithUserID($userID): string
    {
        $data = DB::makeConnection()->query("SELECT token FROM users WHERE ID='" . $userID . "'")->fetch_assoc();
        return $data['token'];
    }

    public static function checkPasswordExist($userID,$password): bool
    {
        $query = DB::makeConnection()->query("SELECT ID FROM users WHERE ID='" . $userID . "' AND password='" . $password . "'")
            ->fetch_assoc();
        return !empty($query) ? true : false;
    }
}