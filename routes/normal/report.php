<?php
    $api -> group(['prefix' => 'report', ], function ($api) {
        $api->get('/turnover', 'ReportController@turnover');  
        $api->post('/bookingDay', 'ReportController@BookingWithDay');
        $api->post('/bookingCode', 'ReportController@BookingWithCode');    
    });

?>