<?php


namespace severApp\Models;


use severApp\Database\DB;

class PayModel
{
    public static function getAll()
    {
       return DB::makeConnection()->query("SELECT * FROM HoaDon")->fetch_all();
    }
}