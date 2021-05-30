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
        $status=DB::makeConnection()->query("SELECT * FROM Phong WHERE ID='".$id."'")->fetch_assoc();
         return (empty($status))?0:$status;
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
        $query=[];
        if ($aData['TenPhong']??''){
            $query[]=" TenPhong ='".$aData['TenPhong']."'";
        }
        if ($aData['Gia']??''){
            $query []=" IDTang ='".$aData['IDTang']."'";
        }
        if ($aData['TrangThai']??''){
            $query []=" TrangThai = '".$aData['TrangThai']."'";
        }
        if ($aData['TuSua']??''){
            $query []=" TuSua = '".$aData['TuSua']."'";
        }
        return DB::makeConnection()->query("UPDATE `Phong` SET ".implode(',',$query)." WHERE ID='" . $id . "'");
    }

    public static function updateStatusRoom($id, $aData)
    {
        return DB::makeConnection()
            ->query("UPDATE `Phong` SET `TrangThai`='" . $aData['TrangThai'] . "' WHERE ID='" . $id . "'");
    }
}