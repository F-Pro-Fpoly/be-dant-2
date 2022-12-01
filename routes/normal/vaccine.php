<?php
    $api -> group(['prefix' => 'vaccine'], function ($api) {
        $api->get('/list', 'VaccineController@listVaccineNormal');
        $api->get('/detail/{id:[0-9]+}', 'VaccineController@VaccineDetailNormal');
        $api->get('/detail-by-code/{code}', 'VaccineController@getVaccineByCode');
    });

?>