<?php
    $api -> group(['prefix' => 'setting', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'SettingController@listSetting');
        $api->post('/add', 'SettingController@addSetting');
        $api->get('/detail/{id:[0-9]+}', 'SettingController@settingDetail');
        $api->put('/edit/{id:[0-9]+}', 'SettingController@updateSetting');
        $api->delete('/delete/{id:[0-9]+}', 'SettingController@deleteSetting');
    });
?>