<?php
    $api -> group(['prefix' => 'page'], function ($api) {
        $api->get('/listNormal', 'PageController@listPageNormal');
    });
?>