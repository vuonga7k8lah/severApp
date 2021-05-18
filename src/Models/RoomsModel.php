<?php


namespace severApp\Models;


use severApp\Database\DB;

class RoomsModel
{
    public static function isExist($id): bool
    {
        return !empty(self::getRoom($id));
    }

    public static function getAll()
    {
        return DB::makeConnection()->query("SELECT * FROM Phong")->fetch_all();
    }

    public static function getRoom($id)
    {
        $status=DB::makeConnection()->query("SELECT * FROM phong WHERE ID='".$id."'");
         return (empty($status))?0:$status->fetch_assoc();
    }

    public static function insert($aData)
    {
        return DB::makeConnection()
            ->query("INSERT INTO `Phong`(`ID`, `IDTang`, `TenPhong`, `Gia`, `TrangThai`, `TuSua`) VALUES (null,'" .
                $aData['IDTang'] .
                "','" . $aData['TenPhong'] . "','" . $aData['Gia'] . "','" . $aData['TrangThai'] . "','" .
                $aData['TuSua'] . "')");
    }

    public static function delete($id)
    {
        return DB::makeConnection()->query("DELETE FROM `Phong` WHERE ID='" . $id . "'");
    }

    public static function update($id, $aData)
    {
        return DB::makeConnection()
            ->query("UPDATE `Phong` SET `TenPhong`='" . $aData['TenPhong'] . "',`IDTang`='" . $aData['IDTang'] .
                "',`Gia`='"
                . $aData['Gia'] . "',`TrangThai`='" . $aData['TrangThai'] . "',`TuSua`='" . $aData['TuSua'] .
                "' WHERE ID='" . $id . "'");
    }

    public static function updateStatusRoom($id, $aData)
    {
        return DB::makeConnection()
            ->query("UPDATE `Phong` SET `TrangThai`='" . $aData['TrangThai'] . "' WHERE ID='" . $id . "'");
    }
}