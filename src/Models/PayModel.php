<?php


namespace severApp\Models;


use severApp\Database\DB;

class PayModel
{
    public static function getAll()
    {
        return DB::makeConnection()->query("SELECT * FROM HoaDon")->fetch_all();
    }

    public static function insert($aData)
    {
        $sql
            = "INSERT INTO `HoaDon`(`ID`, `IDPhong`, `IDUser`, `infoKhach`, `DichVu`, `ThanhToan`, `createDate`) VALUES (null,'" .
            $aData['IDPhong'] . "','" . $aData['IDUser'] . "','" . $aData['infoKhach'] . "','" . $aData['DichVu'] .
            "','" . $aData['ThanhToan'] . "',null)";
        return DB::makeConnection()->query($sql);
    }

    public static function isExist($id): bool
    {
        return !empty(self::getPayWithID($id));
    }

    public static function getPayWithID($id)
    {
        $ID = DB::makeConnection()->query("SELECT * FROM HoaDon WHERE ID='" . $id . "'");
        return !empty($id) ? $ID->fetch_assoc() : 0;
    }

    public static function update($id, $aData)
    {
        $query = [];
        if ($aData['IDUser'] ?? '') {
            $query[] = " IDUser ='" . $aData['IDUser'] . "'";
        }
        if ($aData['ThanhToan'] ?? '') {
            $query [] = " ThanhToan ='" . $aData['ThanhToan'] . "'";
        }
        if ($aData['IDPhong'] ?? '') {
            $query [] = " IDPhong = '" . $aData['IDPhong'] . "'";
        }
        if ($aData['DichVu'] ?? '') {
            $query [] = " DichVu = '" . $aData['DichVu'] . "'";
        }
        $query = array_merge($query, [" createDate = null"]);
        return DB::makeConnection()->query("UPDATE `HoaDon` SET " . implode(',', $query) . " WHERE ID='" . $id . "'");
    }

    public static function delete($id)
    {
        return DB::makeConnection()->query("DELETE FROM HoaDon WHERE ID='" . $id . "'");
    }

    public static function insertThanhToan($aData)
    {
        return DB::makeConnection()
            ->query("INSERT INTO `ThanhToan`(`ID`, `IDHoaDon`, `TongTien`, `createDate`) VALUES (null ," .
                $aData['IDHoaDon'] . "," . $aData['TongTien'] . ",null)");
    }

    public static function getFields($id,$field)
    {
        $query= DB::makeConnection()->query("SELECT ".$field." FROM HoaDon WHERE ID=".$id."");
        return (!empty($query))?($query->fetch_assoc())[$field]:'';
    }
}