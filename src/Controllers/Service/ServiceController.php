<?php


namespace severApp\Controllers\Service;


use severApp\Core\TrainJWT;
use severApp\Helpers\Message;
use severApp\Models\ServiceModel;

class ServiceController
{
    use TrainJWT;

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

    public function registerServices()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if (checkValidateData($aData)) {
                $status = ServiceModel::insert($aData);
                if ($status) {
                    echo Message::success('Create Dịch Vụ Thành Công', []);
                    die();
                }
                echo Message::error('Create Dịch Vụ Không Thành Công', 401);
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function updateServices()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if (checkValidateData($aData)) {
                $status = ServiceModel::update($aData);
                if ($status) {
                    echo Message::success('Update Dịch Vụ Thành Công', []);
                    die();
                }
                echo Message::error('Update Dịch Vụ Không Thành Công', 401);
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        }
        echo Message::error('User not access', 401);
    }

    public function deleteServices()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if (checkValidateData($aData)) {
                $status = ServiceModel::delete($aData);
                if ($status) {
                    echo Message::success('Delete Dịch Vụ Thành Công', []);
                    die();
                }
                echo Message::error('Delete Dịch Vụ Không Thành Công', 401);
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
            }
        }
        echo Message::error('User not access', 401);
    }

}