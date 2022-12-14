<?php
$api -> group(['prefix' => 'user'], function ($api) {
    $api -> group(['middleware' => 'role:admin,doctor' ], function ($api){
        $api->post('/add', 'UserController@addUser');
        $api->get('/list', 'UserController@listUser');
        $api->get('/list-v2', 'UserController@listUserV2');
        $api->delete('/delete/{id}', 'UserController@deleteUser');
        $api->put('/updateByName', 'UserController@updateByName');
        $api->get('/listPatient', 'UserController@listPatient');
        $api->get('/listPatientDetail', 'UserController@listPatientDetail');
    });

    $api->group(['middleware' => 'role:doctor'], function ($api) {
        $api->get('/get-medical-record/{id}', 'UserController@exportPDFMedicalRecord');
    });
  
    $api->get('/info', 'UserController@getInfo');
    $api->get('/{id}', 'UserController@getUser');
  
    $api->put('/update/{id:[0-9]+}', 'UserController@update');
    $api->put('/changePassword/{id:[0-9]+}', 'UserController@updatePassword');

});


?>