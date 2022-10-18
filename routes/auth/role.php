<?php
$api -> group(['prefix' => 'role', 'middleware' => 'role:admin'], function ($api) {
    $api->get('/list-all', 'RoleController@listRoleAll');
});


?>