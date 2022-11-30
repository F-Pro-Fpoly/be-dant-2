<?php 
        $api->get('/count', 'CountController@count');
?>
<?php
    $api -> group(['prefix' => 'statistic' ,  'middleware' => 'role:admin' ], function ($api) {
        $api->get('/list', 'CountController@getStatistic');
        $api->get('/chart', 'CountController@getStatisticChart');
    });
?>