<?php
    $api -> group(['prefix' => 'contact'], function ($api) {
        $api->post('/add', 'ContactController@addContact');
        $api->get('/list', 'ContactController@listContact');
        $api->delete('/delete/{id:[0-9]+}', 'ContactController@deleteContact');

    });
?>