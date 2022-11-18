<?php
    $api -> group(['prefix' => 'banner', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'BannerController@listBanner');
        $api->post('/add', 'BannerController@addBanner');
        $api->get('/detail/{id:[0-9]+}', 'BannerController@bannerDetail');
        $api->put('/edit/{id:[0-9]+}', 'BannerController@updateBanner');
        // $api->delete('/delete/{id:[0-9]+}', 'SettingController@deleteSetting');
    });
?>