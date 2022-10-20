<?php
$api->get("/", function() {
    return "web normal";
});


$api->get('/user/{id}', 'TestController@show'); 
$api->get('/list-user', 'TestController@listUser'); 
$api->get('/test-search', 'TestController@testSearch'); 
$api->post('/file', 'TestController@addImg'); 

require_once __DIR__."/page.php";

?>