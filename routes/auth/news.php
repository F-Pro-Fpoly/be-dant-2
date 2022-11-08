<?php
    $api -> group(['prefix' => 'news', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'NewsController@listNews');
        $api->get('/list-news-category', 'NewsController@listNews_category');
        $api->post('/add', 'NewsController@addNews');
        $api->put('/edit/{id:[0-9]+}', 'NewsController@updateNews');
        $api->delete('/delete/{id:[0-9]+}', 'NewsController@deleteNews');
        $api->get('/news-detail/{id:[0-9]+}', 'NewsController@getNewsID');
    });

?>