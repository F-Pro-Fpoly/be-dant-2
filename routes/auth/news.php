<?php
    $api -> group(['prefix' => 'news', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'NewsController@listNews');
        $api->get('/list-news-category', 'NewsController@listNews_category_all');
        $api->post('/add', 'NewsController@addNews');
        $api->put('/edit/{id:[0-9]+}', 'NewsController@updateNews');
        $api->delete('/delete/{id:[0-9]+}', 'NewsController@deleteNews');
        $api->get('/news-detail/{id:[0-9]+}', 'NewsController@getNews_ID');
        $api->get('/news-new', 'NewsController@getNews_new');
        $api->post('/add_news', 'NewsController@addNews');
        $api->put('/update_news/{id:[0-9]+}', 'NewsController@updateNews');

        $api->get('/list_news_comment/{id:[0-9]+}', 'News_commentController@listNews_comment_by_newsID_admin');
        $api->get('/one_news_comment/{id:[0-9]+}', 'News_commentController@OneNews_comment_by_newsID_admin');
        $api->put('/update_news_comment/{id:[0-9]+}', 'News_commentController@updateNews_comment_admin');
        $api->delete('/delete_news_comment/{id:[0-9]+}', 'News_commentController@deleteNews_comment_admin');

    });
    $api -> group(['prefix' => 'news_comment', 'middleware' => 'role:customer, admin,doctor'], function ($api) {
        $api->get('/one_news_comment/{id:[0-9]+}', 'News_commentController@OneNews_comment_by_newsID');
        $api->post('/add_news_comment/{id}', 'News_commentController@addNews_comment');
        $api->put('/update_news_comment/{id:[0-9]+}', 'News_commentController@updateNews_comment');
        $api->delete('/delete_news_comment/{id:[0-9]+}', 'News_commentController@deleteNews_comment');
    });

?>
