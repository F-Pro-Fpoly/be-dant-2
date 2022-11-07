<?php

    // $api->get('/user/{id}', 'TestController@show'); 
    $api->get('/list-user', 'TestController@listUser'); 
    $api->get('/test-search', 'TestController@testSearch'); 
    $api->post('/file', 'TestController@addImg'); 
    $api->get('/user/list', 'UserController@listUser');


?>