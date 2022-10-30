<?php
    $api -> group(['prefix' => 'contact', 'middleware' => 'role:admin'], function ($api) {
        $api->post('/add', 'ContactController@addContact');
        $api->get('/list', 'ContactController@listContact');
        $api->delete('/delete/{id:[0-9]+}', 'ContactController@deleteContact');

    });
?>