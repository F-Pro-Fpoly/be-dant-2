<?php
    $api -> group(['prefix' => 'report', ], function ($api) {
        $api->get('/turnover', 'ReportController@turnover');  
        $api->get('/bookingDay', 'ReportController@BookingWithDay');
        $api->get('/bookingCode', 'ReportController@BookingWithCode');    
    });

?>