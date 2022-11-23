<?php
    $api -> group(['prefix' => 'newsletter', 'middleware' => 'role:admin'], function ($api) {
        $api->get('/list', 'NewsLetterController@listNewsletter');
    });

?>