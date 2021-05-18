<?php


namespace severApp\Controllers\Rooms;


use severApp\Core\TrainJWT;
use severApp\Helpers\FunctionCheck;
use severApp\Helpers\Message;
use severApp\Models\RoomsModel;

class RoomsController
{
    use TrainJWT;

    public function getAllRooms()
    {
        $aResponse = RoomsModel::getAll();
        foreach ($aResponse as $item) {
            $aData[] = [
                'ID'        => $item[0],
                'IDPhong'   => $item[1],
                'TenPhong'  => $item[2],
                'Gia'       => $item[3],
                'TrangThai' => $item[4],
                'TuSua'     => $item[5],
            ];
        }
        echo Message::success('list data', json_encode($aData));
    }

    public function registerRooms()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if ($aData ?? '') {
                $status = RoomsModel::insert($aData);
                if ($status) {
                    echo Message::success('Tạo Phòng Thành Công', []);
                    die();
                }
                echo Message::error('Tạo Phòng Không Thành Công', 401);
            }
        }
        echo Message::error('User not access', 401);
    }

    public function updateRooms()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if ($aData ?? '') {
                $status = RoomsModel::update($aData['ID'], $aData);
                if ($status) {
                    echo Message::success('Update Phòng Thành Công', []);
                    die();
                }
                echo Message::error('Update Phòng Không Thành Công', 401);
            }
        }
        echo Message::error('User not access', 401);
    }

    public function deleteRooms()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if ($aData ?? '') {
                $status = RoomsModel::delete($aData['ID']);
                if ($status) {
                    echo Message::success('DELETE Phòng Thành Công', []);
                    die();
                }
                echo Message::error('DELETE Phòng Không Thành Công', 401);
            }
        }
        echo Message::error('User not access', 401);
    }

    public function updateStatusRooms()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if ($aData ?? '') {
                if (RoomsModel::isExist($aData['ID'])) {
                    $status = RoomsModel::updateStatusRoom($aData['ID'], $aData);
                    if ($status) {
                        echo Message::success('Update Status Phòng Thành Công', []);
                        die();
                    }
                    echo Message::error('Update Status Phòng Không Thành Công', 401);
                }
                echo Message::error('ID Không Tồn Tại', 401);
            }
        }
        echo Message::error('User not access', 401);
    }
}