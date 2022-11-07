<?php 
$api->group(['prefix' => 'schedule'], function ($api) {
    $api->get('/get-by-date/{id}', 'ScheduleController@get_schedule_date_by_doctor');
});
?>