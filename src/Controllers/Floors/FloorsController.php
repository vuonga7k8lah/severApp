<?php


namespace severApp\Controllers\Floors;


use severApp\Core\TrainJWT;
use severApp\Helpers\Message;
use severApp\Models\FloorsModel;

class FloorsController
{
    use TrainJWT;

    public function getAllFloors()
    {
        $aResponse = FloorsModel::getAll();
        foreach ($aResponse as $item) {
            $aData[] = [
                'ID'        => $item[0],
                'TenTang'   => $item[1],
                'SoPhong'   => $item[2],
                'TrangThai' => $item[3],
            ];
        }
        echo Message::success('list data', json_encode($aData));
    }

    public function registerFloors()
    {
        $aData = $_POST;

        if ($aData ?? '') {
            if ($this->verifyToken($aData['token'])) {
                $status = FloorsModel::insert($aData);
                if ($status) {
                    echo Message::success('Tạo Tầng Thành Công', []);
                    die();
                }
                echo Message::error('Tạo Tầng Không Thành Công', 401);
            }
            echo Message::error('User not access', 401);
        }

    }

    public function updateFloors()
    {
        $aData = $_POST;
        if ($aData ?? '') {
            if ($this->verifyToken($aData['token'])) {
                $status = FloorsModel::update($aData['ID'], $aData);
                if ($status) {
                    echo Message::success('Update Tầng Thành Công', []);
                    die();
                }
                echo Message::error('Update Tầng Không Thành Công', 401);
            }
        }
        echo Message::error('User not access', 401);
    }

    public function deleteFloors()
    {
        $aData = $_POST;
        if ($aData ?? '') {
            if ($this->verifyToken($aData['token'])) {
                $status = FloorsModel::delete($aData['ID']);
                if ($status) {
                    echo Message::success('Tầng xóa Thành Công', []);
                    die();
                }
                echo Message::error('Tầng xóa Không Thành Công', 401);
            }
        }
        echo Message::error('User not access', 401);
    }
}