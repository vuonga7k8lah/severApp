<?php

use severApp\Core\App;
use severApp\Core\Request;
use severApp\Core\Route;

require_once 'vendor/autoload.php';
App::bind('config/app',require_once 'config/app.php');
Route::Load('config/route.php')->direct(Request::uri(),Request::method());
new \severApp\Controllers\Token\HandleTokenController();