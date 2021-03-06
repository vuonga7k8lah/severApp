<?php

namespace severApp\Controllers\Token;

use severApp\Core\TrainJWT;
use severApp\Helpers\Message;

class HandleTokenController
{
    use TrainJWT;

    public function verifyTokenRole()
    {
        $token = $_POST['token'];
        if (!empty($token)) {
            $role = ($this->verifyToken($token)) ? 2 : 1;
            echo Message::success("check permissions is successfully", ['role' => $role]);
        } else {
            echo Message::error('param token is required', 401);
        }
    }
}