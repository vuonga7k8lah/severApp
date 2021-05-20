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
}