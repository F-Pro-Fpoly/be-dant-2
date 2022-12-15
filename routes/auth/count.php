<?php 
    $api->get('/count', 'CountController@count');

    $api -> group(['prefix' => 'statistic'  ], function ($api) {
        $api->get('/list', 'CountController@getStatistic');
        $api->get('/chart', 'CountController@getStatisticChart');
    });
?>