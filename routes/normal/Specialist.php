<?php
    $api -> group(['prefix' => 'specialist'], function ($api) {
        $api->get('/listSpecialist', 'SpecialistController@listSpecialistNormal');
    });

?>