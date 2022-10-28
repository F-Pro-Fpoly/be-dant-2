<?php
$api->group(['prefix' => 'schedule', 'middleware' => 'role:admin,doctor'],function ($api) {
    $api->post("/create", "ScheduleController@addSchedule");
    $api->get("/list", "ScheduleController@listSchedule");
    $api->get("/list-detail", "ScheduleController@listScheduleDetail");
})

?>