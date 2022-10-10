<?php

    $api -> group(['prefix' => 'specialist', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'SpecialistController@listSpecialist');
        $api->get('/list/{id:[0-9]+}', 'SpecialistController@listSpecialist_id');
        $api->post('/add', 'SpecialistController@addSpecialist');
        $api->put('/update/{id:[0-9]+}', 'SpecialistController@updateSpecialist');
        $api->delete('/delete/{id:[0-9]+}', 'SpecialistController@deleteSpecialist');
    });
?>