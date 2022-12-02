<?php
    $api -> group(['prefix' => 'report', ], function ($api) {
        $api->get('/turnover', 'ReportController@turnover');      
    });

?>