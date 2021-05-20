<?php


namespace severApp\Controllers\Pay;


use severApp\Helpers\Message;
use severApp\Models\PayModel;
use severApp\Models\ServiceModel;

class PayController
{
    public function getAllPay()
    {
        $aResponse = PayModel::getAll();
        foreach ($aResponse as $item) {
            $oInfo = json_decode($item[3]);
            $aInfoKhach = [
                'Ten'    => $oInfo->Ten,
                'CMT'    => $oInfo->CMT,
                'SDT'    => $oInfo->SDT,
                'DiaChi' => $oInfo->DiaChi
            ];
            foreach (explode(',',$item[4]) as $ID){
                $aResponseDV=ServiceModel::getServiceWithID($ID);
                $aDataDV[]=[
                    'TenDV'=>$aResponseDV['TenDV'],
                    'Gia'=>$aResponseDV['Gia']
                ];
            }
            $aData[] = [
                'ID'         => $item[0],
                'IDPhong'    => $item[1],
                'IDUser'     => $item[2],
                'InfoKhach'  => $aInfoKhach,
                'DichVu'     => $aDataDV,
                'ThanhToan'  => $item[5],
                'createDate' => $item[6],
            ];
        }
        echo Message::success('list data', $aData);
    }
}