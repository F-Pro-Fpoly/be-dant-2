<?php

    $api -> group(['prefix' => 'specialist', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'SpecialistController@listSpecialist');
        $api->post('/add', 'SpecialistController@addSpecialist');
        $api->put('/edit/{id:[0-9]+}', 'SpecialistController@updateSpecialist');
        $api->delete('/delete/{id:[0-9]+}', 'SpecialistController@deleteSpecialist');
    });
?>