<?php


namespace severApp\Models;


use severApp\Database\DB;

class StatisticModel
{
    public static function getTotalWithFilter($select, $query,$groupBy='date'): array
    {
        $query = "SELECT " . $select . ",SUM(TongTien) as sum FROM ThanhToan WHERE" . $query . " group by ".$groupBy;
        $result=DB::makeConnection()->query($query)->fetch_all();
        return !empty($result) ? $result: [];
    }
}