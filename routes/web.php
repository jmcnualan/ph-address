<?php

$router->group(
    ['prefix' => 'region'],
    function ($router) {
        $router->get('/', 'RegionController@index');
        $router->get('{regionCode}/province', 'RegionController@province');
    }
);

$router->group(
    ['prefix' => 'province'],
    function ($router) {
        $router->get('/', 'ProvinceController@index');
        $router->get('{provinceCode}/municipality', 'ProvinceController@municipality');
    }
);
