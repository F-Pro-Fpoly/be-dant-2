<?php
$api->group(['prefix' => 'timeslot', 'middleware' => 'role:admin,doctor'],function ($api) {
    $api->get("/list", "ScheduleController@getTimeslot");
    // $api->post("/add", "ScheduleController@createSchedule");
})

?>