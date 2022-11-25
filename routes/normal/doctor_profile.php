<?php
$api -> group(['prefix' => 'doctor-profile'], function ($api) {
    $api->get('/detail/{id:[0-9]+}', 'Doctor_profileController@Doctor_profile_ID');
});
?>