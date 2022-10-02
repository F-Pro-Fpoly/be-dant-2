<?php
    $api -> group(['prefix' => 'booking', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'BookingController@listBooking');
        $api->post('/add', 'BookingController@addBooking');
        $api->put('/edit/{id:[0-9]+}', 'BookingController@updateBooking');
        $api->delete('/delete/{id:[0-9]+}', 'BookingController@deleteBooking');
    });

?>