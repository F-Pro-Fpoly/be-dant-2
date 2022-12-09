<?php
    $api -> group(['prefix' => 'contact' ,  'middleware' => 'role:admin' ], function ($api) {
        $api->get('/list', 'ContactController@listContact');
        $api->get('/detail/{id:[0-9]+}', 'ContactController@listcontact_ID'); 
        $api->put('/replyContact/{id:[0-9]+}', 'ContactController@replyContact');



        $api->delete('/delete/{id:[0-9]+}', 'ContactController@deleteContact');

    });
?>