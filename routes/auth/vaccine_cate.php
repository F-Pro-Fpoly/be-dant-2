<?php
$api->group(['middleware' => 'role:admin'], function($api) {
    $api->get('/vaccine-category/list', 'VaccineCategoryController@list');
    $api->post('/vaccine-category/create', 'VaccineCategoryController@create_vaccine_category');
    $api->put('/vaccine-category/update/{id}', 'VaccineCategoryController@update');
});

?>