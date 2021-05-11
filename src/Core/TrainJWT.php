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
}