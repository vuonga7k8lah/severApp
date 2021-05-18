<?php


namespace severApp\Controllers\User;

use severApp\Core\TrainJWT;
use severApp\Helpers\Message;
use severApp\Models\UserModel;

class AccountController
{
    use TrainJWT;

    public static function getAllUser()
    {
        $aUser=[];
        $aData = UserModel::getAllUser();
        foreach ($aData as $oUSer) {
            $aUser[] = [
                'ID'       => $oUSer[0],
                'HoTen'    => $oUSer[1],
                'userName' => $oUSer[2],
            ];
        }
        echo Message::success('List user', $aUser);
    }

    public function registerUser()
    {
        $aData = $_POST;
        $aData['password'] = md5($_POST['password']);
        if (!UserModel::isUserExist($aData['username'])) {
            $userID = UserModel::insert($aData);
            if ($userID ?? '') {
                $token = $this->encodeJWT([
                    'ID'       => $userID,
                    'username' => $aData['username'],
                    'HoTen'    => $aData['HoTen']
                ]);
                UserModel::updateToken($userID, $token);
                echo Message::success('Tài Khoản Tạo Thành Công', [
                    'token' => $token
                ]);
            }
        } else {
            echo Message::error('Tài Khoản Đã Tồn Tại', 401);
        }
    }

    public function updateUser()
    {
        var_dump('xxx');
        die();
    }

}