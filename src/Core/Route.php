<?php


namespace severApp\Core;


class Route
{
    private static $_sefl  = null;
    private static $aRoute = null;

    public static function Load($route)
    {
        if (self::$_sefl == null) {
            self::$_sefl = new self();
        }
        $aRoute = self::$_sefl;
        include $route;
        return self::$_sefl;
    }

    public static function get($uri, $controller)
    {
        self::$aRoute['GET'][$uri] = $controller;
    }

    public static function post($uri, $controller)
    {
        self::$aRoute['POST'][$uri] = $controller;
    }

    public static function put($uri, $controller)
    {
        self::$aRoute['PUT'][$uri] = $controller;
    }

    public static function delete($uri, $controller)
    {
        self::$aRoute['DELETE'][$uri] = $controller;
    }

    public function direct($uri, $method)
    {
        if (!$controller = $this->routeIsExist($uri, $method)) {
            $this->callRoute('severApp\Controllers\Shop\Page404\Page404Controller', 'getView');
        } else {
            $oinit = explode('@', $controller);
            $this->callRoute($oinit[0], $oinit[1]);
        }
    }

    public function routeIsExist($uri, $method)
    {
        return array_key_exists($uri, self::$aRoute[$method]) ? self::$aRoute[$method][$uri] : false;
    }

    public function callRoute($controller, $method, $para = [])
    {
        $oInit = new $controller;
        call_user_func_array([$oInit, $method], $para);
    }

    public function directGet($aURI, $method)
    {
        if (!$controller = $this->routeIsExist($aURI[0] . '/', $method)) {
            $this->callRoute('severApp\Controllers\Shop\Page404\Page404Controller', 'getView');
        } else {
            $oinit = explode('@', $controller);
            $this->callRoute($oinit[0], $oinit[1], [$aURI[1]]);
        }
    }
}