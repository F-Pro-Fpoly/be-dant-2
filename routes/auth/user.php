<?php
$api -> group(['prefix' => 'user', 'middleware' => 'role:admin'], function ($api) {
    $api->post('/add', 'UserController@addUser');
    $api->get('/list', 'UserController@listUser');
    $api->get('/info', 'UserController@getInfo');
    $api->delete('/delete/{id}', 'UserController@deleteUser');
    $api->get('/{id}', 'UserController@getUser');
    $api->put('/update/{id:[0-9]+}', 'UserController@update');
    $api->put('/updateByName', 'UserController@updateByName');
    $api->put('/changePassword/{id:[0-9]+}', 'UserController@updatePassword');
});


?>