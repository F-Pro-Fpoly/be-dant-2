<?php
    $api -> group(['prefix' => 'page', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'PageController@listPage');
        $api->get('/detail/{id:[0-9]+}', 'PageController@pageDetail');
        $api->post('/add', 'PageController@addPage');
        $api->put('/edit/{id:[0-9]+}', 'PageController@updatePage');
        $api->delete('/delete/{id:[0-9]+}', 'PageController@deletePage');
    });

?>