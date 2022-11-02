<?php
    $api -> group(['prefix' => 'setting'], function ($api) {
        $api->get('/listSetting', 'SettingController@listSettingNormal');
    });
?>