<?php

use severApp\Core\App;
use severApp\Core\Request;
use severApp\Core\Route;

require_once 'vendor/autoload.php';
require_once 'src/Helpers/function.php';
error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
App::bind('config/app',require_once 'config/app.php');

if (Request::method()=='GET'){
    $aURI=explode('/',Request::uri());
    if (count($aURI)>1){
        Route::Load('config/route.php')->directGet($aURI,Request::method());
    }else{
        Route::Load('config/route.php')->direct(Request::uri(),Request::method());
    }
}else{
    Route::Load('config/route.php')->direct(Request::uri(),Request::method());
}
