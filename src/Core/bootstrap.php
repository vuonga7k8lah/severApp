<?php

use severApp\Core\App;
use severApp\Core\Request;
use severApp\Core\Route;

require_once 'vendor/autoload.php';
require_once 'src/Helpers/function.php';
App::bind('config/app',require_once 'config/app.php');
Route::Load('config/route.php')->direct(Request::uri(),Request::method());
