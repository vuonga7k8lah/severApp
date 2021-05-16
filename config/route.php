<?php
/**
 * @var $aRoute severApp\Core\Route
 */
$aRoute->get('token', 'severApp\Controllers\Token\HandleTokenController@test');
$aRoute->get('products', 'severApp\Controllers\Product\ProductController@getProducts');