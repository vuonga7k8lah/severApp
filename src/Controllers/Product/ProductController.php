<?php


namespace severApp\Controllers\Product;


use severApp\Database\DB;

class ProductController
{
    public function getProducts()
    {
        $coverData = [];
        $aData = DB::makeConnection()->query("SELECT * FROM tests")->fetch_all();
        foreach ($aData as $aItem) {
            $coverData[] = [
                'id'         => $aItem[0],
                'HoTen'      => $aItem[1],
                'DiaChi'     => $aItem[2],
                'createDate' => $aItem[3]
            ];
        }
        var_dump($coverData);die();
        echo json_encode($coverData);die();
    }
}