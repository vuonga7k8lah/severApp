<?php

namespace severApp\Controllers\Token;

use severApp\Core\TrainJWT;
use severApp\Database\DB;

class HandleTokenController
{
    use TrainJWT;

    public function test()
    {
        $token = $this->encodeJWT([
            'ID'       => '1',
            'userName' => 'admin',
            'HoTen'    => 'admin'
        ]);
        echo $token;
        var_dump(DB::makeConnection()->query("SELECT * FROM users")->fetch_assoc());die();
        var_dump($this->decodeJWT($token));
    }
}