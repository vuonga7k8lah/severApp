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
        $aUser = [];
        $aData = UserModel::getAllUser();
        foreach ($aData as $oUSer) {
            $aUser[] = [
                'ID'       => $oUSer[0],
                'HoTen'    => $oUSer[1],
                'userName' => $oUSer[2],
                'NgaySinh' => $oUSer[4],
                'CMT'      => $oUSer[5],
                'DiaChi'   => $oUSer[6],
                'role'     => $oUSer[7],
            ];
        }
        echo Message::success('List user', $aUser);
    }

    public function renewPassword()
    {
        $aData = $_POST;
        if (checkValidateData($aData)) {
            if (strcmp($aData['password'], $aData['cfPassword']) == 0) {
                $oInfo = $this->decodeJWT($aData['token']);
                UserModel::update($oInfo->ID, [
                    'password' => md5($aData['password'])
                ]);
                echo Message::success('Your password has been changed successfully');
            } else {
                echo Message::error('your passwords must match', 401);
            }
        } else {
            echo Message::error('The param is not empty', 401);
        }
    }

    public function verifyPassword()
    {
        $aData = $_POST;
        if (checkValidateData($aData)) {
            $oInfo = $this->decodeJWT($aData['token']);
            $status = UserModel::checkPasswordExist($oInfo->ID, md5($aData['password']));
            if ($status) {
                echo Message::success('Congratulations,your password success');
            } else {
                echo Message::error('Sorry,the password is error', 401);
            }
        } else {
            echo Message::error('The param is not empty', 401);
        }
    }

    public function registerUser()
    {
        $aData = $_POST;
        $aData['password'] = md5($_POST['password']);
        if (!(strlen(trim($aData['CMT'])) <= 11)) {
            echo Message::error('Số Chứng Minh Thư Phải dưới 11 số', 401);
            die();
        }
        $aData['CMT'] = (int)$_POST['CMT'];
        if (!UserModel::isUserExist($aData['username'])) {
            if ($this->verifyToken($aData['token'])) {
                $userID = UserModel::insert($aData);
                if ($userID ?? '') {
                    $token = $this->encodeJWT([
                        'ID'       => $userID,
                        'userName' => $aData['username'],
                        'HoTen'    => $aData['HoTen']
                    ]);
                    UserModel::updateToken($userID, $token);
                    echo Message::success('The account create successfully');
                }
            } else {
                echo Message::error('User not access', 401);
            }
        } else {
            echo Message::error('Sorry,the account is exist', 401);
        }
    }

    public function updateUser()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if (checkValidateData($aData)) {
                $status = UserModel::update($aData['ID'], $aData);
                if ($status) {
                    echo Message::success('The account is update successfully');
                } else {
                    echo Message::error('The account is update not successfully', 401);
                }
            } else {
                echo Message::error('The param is not null', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function deleteUser()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if (checkValidateData($aData)) {
                $status = UserModel::delete($aData['ID']);
                if ($status) {
                    echo Message::success('The account is delete successfully');
                } else {
                    echo Message::error('The account is delete not successfully', 401);
                }
            } else {
                echo Message::error('The param is not null', 401);
            }
        } else {
            echo Message::error('User not access', 401);
        }
    }

    public function handleLogin()
    {
        $aData = $_POST;
        if (checkValidateData($aData)) {
            $ID = UserModel::handleLogin($aData);
            if ($ID) {
                echo Message::success('Congratulations, The account login successfully', [
                    'token' => UserModel::getTokenWithUserID($ID)
                ]);
            } else {
                echo Message::error('Sorry, The account login successfully', 401);
            }
        } else {
            echo Message::error('The param is not null', 401);
        }
    }
}