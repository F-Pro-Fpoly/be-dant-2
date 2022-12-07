<?php

    $api->get('/user/infoDoctor/{id}', 'UserController@profileDoctor'); 


    
    // $api->get('/list-user', 'TestController@listUser'); 
    // $api->get('/test-search', 'TestController@testSearch'); 
    $api->post('/user/forgetPass', 'UserController@forgetPassword'); 
    $api->post('/user/ChangePass/{id}', 'UserController@ChangePass'); 
    $api->get('/user/list', 'UserController@listUser');
    $api->put('/user/update-client', [
        'uses' => 'UserController@updateClient',
        'middleware' => 'auth'
    ]);

    $api->get('/user/get-user', [
        'uses' => 'UserController@getUserClient',
        'middleware' => 'auth'
    ]);

?>