<?php
$api -> group(['prefix' => 'district'], function ($api) {
    $api->get('/list-normal', 'DistrictController@index');
});
?>