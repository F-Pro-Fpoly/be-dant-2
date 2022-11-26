<?php
    $api -> group(['prefix' => 'doctor-profile', 'middleware' => 'role:admin,doctor'], function ($api) {
        $api->post('/add', 'Doctor_profileController@addDoctor_profile');
        $api->put('/edit/{id:[0-9]+}', 'Doctor_profileController@updateDoctor_profile');
        $api->delete('/delete/{id:[0-9]+}', 'Doctor_profileController@deleteDoctor_profile');
        $api->get('/list', 'Doctor_profileController@listDoctor_profile');
        $api->get('/detail/{id:[0-9]+}', 'Doctor_profileController@Doctor_profileID');
    });

?>