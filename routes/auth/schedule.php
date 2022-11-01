<?php
$api->group(['prefix' => 'schedule', 'middleware' => 'role:admin,doctor'],function ($api) {
    $api->post("/create", "ScheduleController@addSchedule");
    $api->get("/list", "ScheduleController@listSchedule");
    $api->get("/list-detail", "ScheduleController@listScheduleDetail");
    $api->get("/list-time-slot-by-schedule/{id:[0-9]+}", "ScheduleController@getTimeSlotBySchedule");
    $api->post("/add-time-slot-detail-by-schedule", "ScheduleController@addTimeSlotDetailToSchedule");
})

?>