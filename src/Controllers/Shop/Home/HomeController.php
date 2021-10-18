<?php

namespace severApp\Controllers\Shop\Home;

use severApp\Core\App;

class HomeController
{
    public function getView()
    {
        require_once 'src/Views/Shop/Home/Home.php';
    }
}