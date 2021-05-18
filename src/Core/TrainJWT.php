<?php


namespace severApp\Core;

use Firebase\JWT\JWT;
use mysql_xdevapi\Exception;
use severApp\Models\UserModel;

trait TrainJWT
{
    private $key = 'vuongdttn-1998';

    public function verifyToken($token): bool
    {
        try {
            $oInfo = $this->decodeJWT($token);
            return UserModel::isUserExist($oInfo->userName);
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }

    public function decodeJWT($token): object
    {
        return JWT::decode($token, $this->key, ['HS256']);
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