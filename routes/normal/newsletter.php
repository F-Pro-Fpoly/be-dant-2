<?php
    $api->group(['prefix' => 'newsletter'], function ($api) {
        $api->post('/add_newsletter', 'NewsLetterController@add_Newsletter');
        
    });
?>
