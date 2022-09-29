<?php
    $api -> group(['prefix' => 'sick', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'SickController@listSick');
        $api->post('/add', 'SickController@addSick');
        $api->put('/edit/{id}', 'SickController@updateSick');
        $api->delete('/delete/{id}', 'SickController@deleteSick');
    });

?>