<?php 

$api->group(['middleware' => 'role:doctor'], function($api) {
    $api->put('/injection-info/update', 'Injection_infoController@update_injection_info');
    $api->post('/injection-info/add', 'Injection_infoController@create_injection_info');
});