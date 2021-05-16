<?php


namespace severApp\Core;

use Firebase\JWT\JWT;

trait TrainJWT
{
    private $key = 'vuongdttn-1998';

    public function encodeJWT($aData)
    {
        return JWT::encode($aData, $this->key);
    }

    public function decodeJWT($token)
    {
        return JWT::decode($token, $this->key, ['HS256']);
    }
    /*
     * $time tính theo giờ
     */
    public function setTime($time='')
    {
        JWT::$leeway = (!empty($time))?$time*60*60:864000;
        return $this;
    }
}