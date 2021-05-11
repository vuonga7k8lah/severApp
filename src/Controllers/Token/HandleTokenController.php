<?php

namespace severApp\Controllers\Token;

use severApp\Core\TrainJWT;

class HandleTokenController
{
    use TrainJWT;

    public function test()
    {
        $token= $this->encodeJWT([
            'username' => '1111',
            'userId'   => '1111',
            'Data'     => '1111'
        ]);
        echo $token;
        var_dump($this->decodeJWT($token));
    }
}