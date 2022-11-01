<?php
$api->group(['prefix' => 'schedule', 'middleware' => 'role:admin,doctor'],function ($api) {
    $api->get("/list", "ScheduleController@listSchedule");
    $api->post("/add", "ScheduleController@createSchedule");
})

?>