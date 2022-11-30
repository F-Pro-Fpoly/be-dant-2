<?php
    $api -> group(['prefix' => 'vaccine', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'VaccineController@listVaccine');
        $api->post('/add', 'VaccineController@addVaccine');
        $api->put('/edit/{id:[0-9]+}', 'VaccineController@updateVaccine');
        $api->delete('/delete/{id:[0-9]+}', 'VaccineController@deleteVaccine');
        $api->get('/{id}', 'VaccineController@show');
    });

?>