<?php


namespace severApp\Core;

use Firebase\JWT\JWT;
use mysql_xdevapi\Exception;
use severApp\Models\UserModel;

trait TrainJWT
{
    private $key = 'vuongdttn-1998';

    public function verifyToken($token,$checkUser=false): bool
    {
        try {
            $oInfo = $this->decodeJWT($token);
            if ($checkUser){
                return UserModel::isUserExist($oInfo->userName);
            }
            return UserModel::isUserAdmin($oInfo->userName);
        } catch (Exception $e) {
            var_dump('Message: ' . $e->getMessage());die();
        }
    }

    public function decodeJWT($token): object
    {
        try {
            return JWT::decode($token, $this->key, ['HS256']);
        }catch (Exception $e) {
            var_dump('Message: ' . $e->getMessage());die();
        }
    }

    /*
     * $time tính theo giờ
     */

    public function encodeJWT($aData): string
    {
        return JWT::encode($aData, $this->key);
    }

    public function setTime($time = ''): TrainJWT
    {
        JWT::$leeway = (!empty($time)) ? $time * 60 * 60 : 864000;
        return $this;
    }
}