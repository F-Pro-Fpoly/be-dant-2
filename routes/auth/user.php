<?php
$api -> group(['prefix' => 'user', 'middleware' => 'role:admin'], function ($api) {
    $api->post('/add', 'UserController@addUser');
    $api->get('/list', 'UserController@listUser');
    $api->delete('/delete/{id}', 'UserController@deleteUser');
});


?>