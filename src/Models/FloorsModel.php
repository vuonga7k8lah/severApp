<?php


namespace severApp\Models;


use severApp\Database\DB;

class FloorsModel
{
    public static function insert($aData)
    {
        if(count(self::getAll()) <= 5){
            return DB::makeConnection()
                ->query("INSERT INTO `Tang`(`ID`, `TenTang`, `SoPhong`, `TrangThai`) VALUES (null,'" . $aData['TenTang'] .
                    "','" . $aData['TenTang'] . "',1)");
        }
    }

    public static function delete($id)
    {
        return DB::makeConnection()->query("DELETE FROM `Tang` WHERE ID='" . $id . "'");
    }

    public static function update($id, $aData)
    {
        return DB::makeConnection()
            ->query("UPDATE `Tang` SET `TenTang`='" . $aData['TenTang'] . "',`SoPhong`='" . $aData['SoPhong'] .
                "',`TrangThai`='" . $aData['TrangThai'] . "' WHERE ID='" . $id . "'");
    }

    public static function getAll()
    {
        return DB::makeConnection()->query("SELECT * FROM Tang")->fetch_all();
    }
    public static function getFloor($id): ?array
    {
        return DB::makeConnection()->query("SELECT * FROM Tang where ID='".$id."'")->fetch_assoc();
    }
}