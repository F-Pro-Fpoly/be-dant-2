<?php
    $api -> group(['prefix' => 'news_category', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'News_categoryController@listNews_category');
        $api->get('/list-news', 'News_categoryController@listNews');
        $api->post('/add', 'News_categoryController@addNews_category');
        $api->put('/edit/{id:[0-9]+}', 'News_categoryController@updateNews_category');
        $api->delete('/delete/{id:[0-9]+}', 'News_categoryController@deleteNews_category');
        $api->get('/news-categoryID/{id:[0-9]+}', 'News_categoryController@getNews_categoryID');
    });

?>