<?php
    $api -> group(['prefix' => 'vaccine_category'], function ($api) {
        $api->get('/list_dmCategory', 'VaccineCategoryController@list');
    });

?>