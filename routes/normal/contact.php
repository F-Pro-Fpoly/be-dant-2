<?php
    $api -> group(['prefix' => 'contact'], function ($api) {
        $api->post('/add', 'ContactController@addContact');

    });
?>