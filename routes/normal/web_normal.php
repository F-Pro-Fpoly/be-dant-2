<?php
$api->get("/", function() {
    return "web normal";
});


$api->get('/user/{id}', 'TestController@show'); 
$api->get('/list-user', 'TestController@listUser'); 
$api->post('/file', 'TestController@addImg'); 

?>