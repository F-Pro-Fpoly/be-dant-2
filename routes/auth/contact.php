<?php
    $api -> group(['prefix' => 'contact', 'middleware' => 'role:admin'], function ($api) {
        $api->post('/add', 'ContactController@addContact');
        $api->delete('/delete/{id:[0-9]+}', 'ContactController@deleteContact');

    });
?>