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


$router->get('/', "ExampleController@index");

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

$router->group(['prefix' => 'admin/roles'], function ($router){
    $router->get('/test', 'RolesController@test');
    $router->get('/list', 'RolesController@listRoles');
    $router->get('/list/{id}', 'RolesController@listRoles_ID');
    $router->post('/add', 'RolesController@addRoles');
    $router->put('/update/{id}', 'RolesController@updateRoles');
    $router->delete('/delete/{id}', 'RolesController@deleteRoles');

});
// national
$router->group(['prefix' => 'admin/national'], function ($router){
    $router->get('/test', 'NationalController@test');
    $router->get('/list', 'NationalController@listNational');
    $router->get('/list/{id}', 'NationalController@listNational_ID');
    $router->post('/add', 'NationalController@addNational');
    $router->put('/update/{id}', 'NationalController@updateNational');
    $router->delete('/delete/{id}', 'NationalController@deleteNational');
});
// Specialist
$router->group(['prefix' => 'admin/specialist'], function ($router){
    $router->get('/test', 'SpecialistController@test');
    $router->get('/list', 'SpecialistController@listSpecialist');
    $router->get('/list/{id}', 'SpecialistController@listSpecialist_ID');
    $router->post('/add', 'SpecialistController@addSpecialist');
    $router->put('/update/{id}', 'SpecialistController@updateSpecialist');
    $router->delete('/delete/{id}', 'SpecialistController@deleteSpecialist');
});
// Department
$router->group(['prefix' => 'admin/department'], function ($router){
    $router->get('/list', 'DepartmentController@listDepartment');
    $router->get('/list/{id}', 'DepartmentController@listDepartment_ID');
    $router->post('/add', 'DepartmentController@addDepartment');
    $router->put('/update/{id}', 'DepartmentController@updateDepartment');
    $router->delete('/delete/{id}', 'DepartmentController@deleteDepartment');
});
// Schedule
$router->group(['prefix' => 'admin/schedule'], function ($router){
    $router->get('/list', 'ScheduleController@listSchedule');
    $router->get('/list/{id}', 'ScheduleController@listSchedule_ID');
    $router->post('/add', 'ScheduleController@addSchedule');
    $router->put('/update/{id}', 'ScheduleController@updateSchedule');
    $router->delete('/delete/{id}', 'ScheduleController@deleteSchedule');
});
// Histories
$router->group(['prefix' => 'admin/histories'], function ($router){
    $router->get('/list', 'HistoriesController@listHistories');
    $router->get('/list/{id}', 'HistoriesController@listHistories_ID');
    $router->post('/add', 'HistoriesController@addHistories');
    $router->put('/update/{id}', 'HistoriesController@updateHistories');
    $router->delete('/delete/{id}', 'HistoriesController@deleteHistories');
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


