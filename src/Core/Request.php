<?php


namespace severApp\Core;


class Request
{
    public static function uri()
    {
        return str_replace(App::get('config/app')['HomeURL'], '', $_SERVER['REQUEST_URI']);
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}