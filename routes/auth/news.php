<?php
    $api -> group(['prefix' => 'news', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'NewsController@listNews');
        $api->post('/add', 'NewsController@addNews');
        $api->put('/edit/{id:[0-9]+}', 'NewsController@updateNews');
        $api->delete('/delete/{id:[0-9]+}', 'NewsController@deleteNews');
    });

?>