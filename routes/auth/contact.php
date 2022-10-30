<?php
    $api -> group(['prefix' => 'contact', 'middleware' => 'role:admin'], function ($api) {
        $api->post('/add', 'ContactController@addContact');
    });
?>