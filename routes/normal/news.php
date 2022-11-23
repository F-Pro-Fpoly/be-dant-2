<?php
    $api->group(['prefix' => 'news'], function ($api) {
        $api->get('/list-news-catagory', 'News_categoryController@listNews_category_all');
        $api->get('list-news-all', 'NewsController@listNews_all');
        $api->get('/list-news', 'News_categoryController@getNews');
        $api->get('/list-news-in-category/{id:[0-9]+}', 'News_categoryController@getNewsInCategory');
        $api->get('/news-detail/{id}', 'NewsController@getNewsID');
        $api->get('/news-categoryID/{id:[0-9]+}', 'News_categoryController@getNews_categoryID');
        $api->get('/featured', 'NewsController@getNews_featured');
        $api->get('/count_new_categoryID/{id:[0-9]+}', 'News_categoryController@count_new_categoryID');
        $api->get('/news-new', 'NewsController@getNews_new');
        $api->post('/add_news', 'NewsController@addNews');
        $api->put('/update_news/{id:[0-9]+}', 'NewsController@updateNews');
        $api->get('/list', 'NewsController@listall');
    });
?>
