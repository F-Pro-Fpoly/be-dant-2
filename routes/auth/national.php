<?php
$api->group(['middleware'=> 'role:admin'], function ($api) {
    $api->get('/national/list', "NationalController@listNational");
});

?>