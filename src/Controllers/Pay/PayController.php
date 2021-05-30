<?php


namespace severApp\Controllers\Pay;


use severApp\Core\TrainJWT;
use severApp\Helpers\Message;
use severApp\Models\PayModel;
use severApp\Models\RoomsModel;
use severApp\Models\ServiceModel;

class PayController
{
    use TrainJWT;

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
            foreach (explode(',', $item[4]) as $ID) {
                $aResponseDV = ServiceModel::getServiceWithID($ID);
                $aDataDV[] = [
                    'TenDV' => $aResponseDV['TenDV'],
                    'Gia'   => $aResponseDV['Gia']
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

    public function registerPay()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'],true)) {
            if (checkValidateData($aData)) {
                $aUserData = $this->decodeJWT($aData['token']);
                $aData['IDUser'] = $aUserData->ID;
                if (!checkIDPhong($aData['IDPhong'])) {
                    echo Message::error('Phòng không tồn tại', 401);
                }
                $aInfoKhach = [
                    'Ten'    => $aData['Ten'],
                    'CMT'    => $aData['CMT'],
                    'SDT'    => $aData['SDT'],
                    'DiaChi' => $aData['DiaChi']
                ];
                $aData['infoKhach']=json_encode($aInfoKhach);
                $aData['ThanhToan']= (int) handlePays($aData['DichVu']) + (int) (RoomsModel::getRoom
                    ($aData['IDPhong'])['Gia']);
                $status = PayModel::insert($aData);
                if ($status) {
                    echo Message::success('Create Hóa Đơn Thành Công', []);
                    die();
                }
                echo Message::error('Create Hóa Đơn Không Thành Công', 401);
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function deletePay()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'],true)) {
            if (checkValidateData($aData)) {
                if (PayModel::isExist($aData['ID'])){
                    $status = PayModel::delete($aData['ID']);
                    if ($status) {
                        echo Message::success('Delete Hóa Đơn Thành Công', []);
                        die();
                    }
                    echo Message::error('Delete Hóa Đơn Không Thành Công', 401);
                }else{
                    echo Message::error('Hóa Đơn Không Tồn Tại', 401);
                }
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function updatePay()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token']) || $this->verifyToken($aData['token'],true)) {
            if (checkValidateData($aData)) {
                if (PayModel::isExist($aData['ID'])){
                    $aUserData = $this->decodeJWT($aData['token']);
                    $aData['IDUser'] = $aUserData->ID;
                    if (!checkIDPhong($aData['IDPhong'])) {
                        echo Message::error('Phòng không tồn tại', 401);
                    }
                    $aData['ThanhToan']= (int) handlePays($aData['DichVu']) + (int) (RoomsModel::getRoom
                        ($aData['IDPhong'])['Gia']);
                    $status = PayModel::update($aData['ID'],$aData);
                    if ($status) {
                        echo Message::success('Update Hóa Đơn Thành Công', []);
                        die();
                    }
                    echo Message::error('Update Hóa Đơn Không Thành Công', 401);
                }else{
                    echo Message::error('Hóa Đơn Không Tồn Tại', 401);
                }
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }
}