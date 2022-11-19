<?php
    $api -> group(['prefix' => 'contact'], function ($api) {
        $api->post('/add', 'ContactController@addContact');
        $api->get('/list', 'ContactController@listContact');
        $api->get('/detail/{id:[0-9]+}', 'ContactController@listcontact_ID');
        $api->put('/edit/{id:[0-9]+}', 'ContactController@updateContact');
        $api->delete('/delete/{id:[0-9]+}', 'ContactController@deleteContact');

    });
?>