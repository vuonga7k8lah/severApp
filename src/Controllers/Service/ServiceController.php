<?php


namespace severApp\Controllers\Service;


use severApp\Helpers\Message;
use severApp\Models\ServiceModel;

class ServiceController
{
    public function getAllServices()
    {
        $aResponse = ServiceModel::getAll();
        foreach ($aResponse as $item) {
            $aData[] = [
                'ID'        => $item[0],
                'TenDV'     => $item[1],
                'Gia'       => $item[2],
                'TrangThai' => $item[3],
            ];
        }
        echo Message::success('list data', $aData);
    }

    public function createServices()
    {
    }

    public function updateServices()
    {
    }

    public function deleteServices()
    {
    }
    
}