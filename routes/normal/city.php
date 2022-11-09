<?php
$api -> group(['prefix' => 'city'], function ($api) {
    $api->get('/list-normal', 'CityController@index');
});

?>