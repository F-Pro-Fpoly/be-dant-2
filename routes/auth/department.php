<?php
    $api -> group(['prefix' => 'department', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'DepartmentController@listDepartment');
        $api->get('/detail/{id:[0-9]+}', 'DepartmentController@listDepartment_ID');
        $api->post('/add', 'DepartmentController@addDepartment');
        $api->put('/edit/{id:[0-9]+}', 'DepartmentController@updateDepartment');
        $api->delete('/delete/{id:[0-9]+}', 'DepartmentController@deleteDepartment');
    });
?>