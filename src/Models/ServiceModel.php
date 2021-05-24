<?php


namespace severApp\Models;


use severApp\Database\DB;

class ServiceModel
{
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
        $sql="INSERT INTO `DichVu`(`ID`, `TenDV`, `Gia`, `TrangThai`) VALUES (null,'" . $aData['TenDV'] . "','" .
            $aData['Gia'] . "','" . $aData['TrangThai'] . "')";
        return DB::makeConnection()->query($sql);
    }

    public static function update($aData)
    {
        $query=[];
        if ($aData['TenDV']??''){
            $query[]=" TenDV ='".$aData['TenDV']."'";
        }
        if ($aData['Gia']??''){
            $query []=" Gia ='".$aData['Gia']."'";
        }
        if ($aData['TrangThai']??''){
            $query []=" TrangThai = '".$aData['TrangThai']."'";
        }
        return DB::makeConnection()->query("UPDATE `DichVu` SET ".implode(',',$query)." WHERE ID='" . $aData['ID'] . "'");
    }
    public static function delete($aData)
    {
        return DB::makeConnection()->query("DELETE FROM `DichVu` WHERE ID='".$aData['ID']."'");
    }
}