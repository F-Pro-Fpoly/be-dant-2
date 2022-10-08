<?php
    $api->group(['prefix' => 'specialist', 'middleware' => 'role:admin'], function ($api){
        $api->get('/test', 'SpecialistController@test');
        $api->get('/list', 'SpecialistController@listSpecialist');
        $api->get('/list/{id}', 'SpecialistController@listSpecialist_ID');
        $api->post('/add', 'SpecialistController@addSpecialist');
        $api->put('/update/{id}', 'SpecialistController@updateSpecialist');
        $api->delete('/delete/{id}', 'SpecialistController@deleteSpecialist');
    });
?>