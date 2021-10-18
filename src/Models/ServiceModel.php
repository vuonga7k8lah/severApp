<?php


namespace severApp\Models;


use severApp\Database\DB;

class ServiceModel
{
    public static function isExist($id): bool
    {
        return !empty(self::getID($id));
    }

    public static function getID($id): int
    {
        $aID = DB::makeConnection()->query("SELECT ID FROM DichVu WHERE ID='" . $id . "'")->fetch_assoc();
        return !empty($id) ? $aID['ID'] : 0;
    }

    public static function getAll()
    {
        return DB::makeConnection()->query("SELECT * FROM DichVu")->fetch_all();
    }

    public static function getServiceWithID($ID): ?array
    {
        return DB::makeConnection()->query("SELECT * FROM DichVu WHERE ID='" . $ID
            . "'")->fetch_assoc();
    }

    public static function insert($aData)
    {
        $sql = "INSERT INTO `DichVu`(`ID`, `TenDV`, `Gia`, `TrangThai`) VALUES (null,'" . $aData['TenDV'] . "','" .
            $aData['Gia'] . "','" . $aData['TrangThai'] . "')";
        return DB::makeConnection()->query($sql);
    }

    public static function update($aData)
    {
        $query = [];
        if ($aData['TenDV'] ?? '') {
            $query[] = " TenDV ='" . $aData['TenDV'] . "'";
        }
        if ($aData['Gia'] ?? '') {
            $query [] = " Gia ='" . $aData['Gia'] . "'";
        }
        if (isset($aData['TrangThai']) && (($aData['TrangThai']=='0')||($aData['TrangThai']=='1'))) {
            $query [] = " TrangThai = '" . $aData['TrangThai'] . "'";
        }
        $sql="UPDATE `DichVu` SET " . implode(',', $query) . " WHERE ID='" .
            $aData['ID'] . "'";
        return DB::makeConnection()->query($sql);
    }

    public static function delete($aData)
    {
        return DB::makeConnection()->query("DELETE FROM `DichVu` WHERE ID='" . $aData['ID'] . "'");
    }

    public static function getGiaWithID($id): int
    {
        $query = DB::makeConnection()->query("SELECT Gia FROM DichVu WHERE ID='" . $id . "'")->fetch_assoc();
        return $query['Gia'];
    }
}