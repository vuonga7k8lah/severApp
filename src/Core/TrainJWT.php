<?php


namespace severApp\Core;

use Exception;
use Firebase\JWT\JWT;
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
            }else{
                return UserModel::isUserAdmin($oInfo->userName);
            }
        } catch (Exception $e) {
            var_dump('Message: ' . $e->getMessage());die();
        }
    }

    public function decodeJWT($token)
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