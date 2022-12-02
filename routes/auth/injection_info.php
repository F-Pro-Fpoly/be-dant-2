<?php 

$api->group(['middleware' => 'role:doctor'], function($api) {
    $api->put('/injection-info/update', 'Injection_infoController@update_injection_info');
});