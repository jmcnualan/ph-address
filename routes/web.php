<?php

$router->group(
    ['prefix' => 'region'],
    function ($router) {
        $router->get('/', 'RegionController@index');
        $router->get('{regionCode}/province', 'RegionController@province');
    }
);
