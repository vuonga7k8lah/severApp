<?php

namespace severApp\Core;

class App
{
    private static $aConfig = [];

    public static function bind($key, $value)
    {
        self::$aConfig[$key] = $value;
    }

    public static function get($key)
    {
        return array_key_exists($key, self::$aConfig) ? self::$aConfig[$key] : '';
    }
}