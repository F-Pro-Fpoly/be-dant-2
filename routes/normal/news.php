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
        $api->get('/list', 'NewsController@listall');
        $api->get('/topWeek1', 'NewsController@getTopWeek1');
        $api->get('/topWeek3', 'NewsController@getTopWeek3');
        $api->get('/news-comment/{id:[0-9]+}', 'News_commentController@listNews_comment_by_newsID');
    });
?>
