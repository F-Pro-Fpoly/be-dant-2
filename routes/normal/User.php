<?php

    $api->get('/user/infoDoctor/{id}', 'UserController@profileDoctor'); 


    
    // $api->get('/list-user', 'TestController@listUser'); 
    // $api->get('/test-search', 'TestController@testSearch'); 
    // $api->post('/file', 'TestController@addImg'); 
    $api->get('/user/list', 'UserController@listUser');


?>