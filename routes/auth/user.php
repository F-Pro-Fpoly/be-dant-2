<?php
$api -> group(['prefix' => 'user'], function ($api) {
    $api -> group(['middleware' => 'role:admin' ], function ($api){
        $api->post('/add', 'UserController@addUser');
        $api->get('/list', 'UserController@listUser');
        $api->delete('/delete/{id}', 'UserController@deleteUser');
        $api->put('/updateByName', 'UserController@updateByName');
    });
  
    $api->get('/info', 'UserController@getInfo');
    $api->get('/{id}', 'UserController@getUser');
    $api->put('/update/{id:[0-9]+}', 'UserController@update');
    $api->put('/changePassword/{id:[0-9]+}', 'UserController@updatePassword');

});


?>