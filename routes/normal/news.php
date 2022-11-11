<?php 
    $api->group(['prefix' => 'news'], function ($api) {
        $api->get('/list-news-catagory', 'News_categoryController@listNews_category_all');
        $api->get('list-news-all', 'NewsController@listNews_all');
        $api->get('/list-news', 'News_categoryController@getNews');
        $api->get('/list-news-in-category/{id:[0-9]+}', 'News_categoryController@getNewsInCategory');
        $api->get('/news-detail/{id:[0-9]+}', 'NewsController@getNewsID');
        $api->get('/news-categoryID/{id:[0-9]+}', 'News_categoryController@getNews_categoryID');
        $api->get('/featured', 'NewsController@getNews_featured');
        $api->get('/news-new', 'NewsController@getNews_new');
    });
?>