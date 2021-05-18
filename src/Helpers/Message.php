<?php


namespace severApp\Helpers;


class Message
{
    public static function error($msg, $code)
    {
        return json_encode([
            'status' => 'error',
            'msg'    => $msg,
            'code'   => $code
        ]);
    }

    public static function success($msg, $aData = [])
    {
        return json_encode([
            'status' => 'success',
            'msg'    => $msg,
            'data'   => $aData,
            'code'   => 200
        ]);
    }
}