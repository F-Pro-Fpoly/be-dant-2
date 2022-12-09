<?php
    $api -> group(['prefix' => 'sick', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'SickController@listSick');
        $api->get('/detail/{id:[0-9]+}', 'SickController@SickDetail');
        $api->post('/add', 'SickController@addSick');
        $api->put('/edit/{id:[0-9]+}', 'SickController@updateSick');
        $api->delete('/delete/{id:[0-9]+}', 'SickController@deleteSick');
    });

?>