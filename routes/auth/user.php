<?php
$api -> group(['prefix' => 'user', 'middleware' => 'role:admin'], function ($api) {
    $api->post('/add', 'UserController@addUser');
    $api->get('/list', 'UserController@listUser');
    
});


?>