<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
// $router->get('/quangdu', function() {
//     return "Quang Dự";
// });
// $router::prefix('admin')->group(function ($router) {
//     $router->post('/roles', 'AdminController@roles');
// });
$router->group(['prefix' => 'admin/roles'], function ($router){
    $router->get('/test', 'RolesController@test');
    $router->get('/list', 'RolesController@listRoles');
    $router->get('/list/{id}', 'RolesController@listRoles_ID');
    $router->post('/add', 'RolesController@addRoles');
    $router->post('/update/{id}', 'RolesController@updateRoles');
    $router->delete('/delete/{id}', 'RolesController@deleteRoles');

});
// national
$router->group(['prefix' => 'admin/national'], function ($router){
    $router->get('/test', 'NationalController@test');
    $router->get('/list', 'NationalController@listNational');
    $router->get('/list/{id}', 'NationalController@listNational_ID');
    $router->post('/add', 'NationalController@addNational');
    $router->post('/update/{id}', 'NationalController@updateNational');
    $router->delete('/delete/{id}', 'NationalController@deleteNational');

});


$api = app('Dingo\Api\Routing\Router');



$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {
    $api->group(['prefix' => 'normal'], function ($api){
        
        require_once __DIR__."/normal/web_normal.php";
    });
    
    $api->group(['prefix' => 'auth', 'middleware' => ['auth']], function ($api) {
        require_once __DIR__."/auth/web_auth.php";
    });
});


