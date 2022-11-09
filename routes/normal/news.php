<?php 
    $api->group(['prefix' => 'news'], function ($api) {
        $api->get('/list-news-catagory', 'News_categoryController@getNews_category');
        $api->get('/list-news', 'News_categoryController@getNews');
        $api->get('/list-news-in-category/{id:[0-9]+}', 'News_categoryController@getNewsInCategory');
        $api->get('/news-detail/{id:[0-9]+}', 'NewsController@getNewsID');
        $api->get('/news-categoryID/{id:[0-9]+}', 'News_categoryController@getNews_categoryID');
    });
?>