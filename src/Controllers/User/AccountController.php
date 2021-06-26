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
    public function renewPassword(){
        $aData = $_POST;
        if (checkValidateData($aData)) {
            if (strcmp($aData['password'], $aData['cfPassword']) == 0) {
                $oInfo = $this->decodeJWT($aData['token']);
                UserModel::update($oInfo->ID,[
                    'password'=>md5($aData['password'])
                ]);
                echo Message::success('Password Bạn Được Cập Nhật Thành Công');
            } else {
                echo Message::error('Password Bạn Nhập Đã Không Khớp Nhau', 401);
            }
        } else {
            echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
        }
    }
    public function verifyPassword()
    {
        $aData = $_POST;
        if (checkValidateData($aData)) {
            $oInfo = $this->decodeJWT($aData['token']);
            $status = UserModel::checkPasswordExist($oInfo->ID, md5($aData['password']));
            if ($status) {
                echo Message::success('Password Bạn Nhập Đúng');
            } else {
                echo Message::error('Password Bạn Nhập Đã Sai', 401);
            }
        } else {
            echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
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
                    echo Message::success('Tài Khoản Tạo Thành Công');
                }
            } else {
                echo Message::error('User not access', 401);
            }
        } else {
            echo Message::error('Tài Khoản Đã Tồn Tại', 401);
        }
    }

    public function updateUser()
    {
        $aData = $_POST;
        if ($this->verifyToken($aData['token'])) {
            if (checkValidateData($aData)) {
                $status = UserModel::update($aData['ID'], $aData);
                if ($status) {
                    echo Message::success('Tài Khoản Update Thành Công');
                } else {
                    echo Message::error('Tài Khoản Update Không Thành Công', 401);
                }
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
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
                    echo Message::success('Tài Khoản Delete Thành Công');
                } else {
                    echo Message::error('Tài Khoản Delete Không Thành Công', 401);
                }
            } else {
                echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
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
                echo Message::success('Tài Khoản Login Thành Công', [
                    'token' => UserModel::getTokenWithUserID($ID)
                ]);
            } else {
                echo Message::error('Tài Khoản Login Không Thành Công', 401);
            }
        } else {
            echo Message::error('Tham Số Truyền Lên Không Được Rỗng', 401);
        }
    }
}