<?php
    // http://127.0.0.1:8000/normal/page/listSpecialist
    $api -> group(['prefix' => 'specialist'], function ($api) {
        $api->get('/listSpecialist', 'SpecialistController@listSpecialistNormal');
        $api->get('/listSpecialistFeature5', 'SpecialistController@listSpecialistFeature5');
    });

?>