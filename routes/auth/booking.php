<?php
    $api -> group(['prefix' => 'booking', 'middleware' => 'role:admin,doctor'], function ($api) {
        $api->get('/list', 'BookingController@listBooking');
        $api->get('/listDoctor', 'BookingController@listBookingDoctor');
        $api->get('/statusBooking', 'BookingController@statusBooking');
        $api->post('/add', 'BookingController@addBooking');
        $api->put('/edit/{id:[0-9]+}', 'BookingController@updateBooking');
        $api->get('/detail/{id:[0-9]+}', 'BookingController@detailBooking');
        $api->delete('/delete/{id:[0-9]+}', 'BookingController@deleteBooking');
    });
    $api -> group(['prefix' => 'booking', 'middleware' => 'auth'], function ($api) {
        $api->get('/mylist/user_id={id:[0-9]+}', 'BookingController@listMyBooking');
    });

?>