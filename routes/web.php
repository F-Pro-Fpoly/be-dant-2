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
use App\Http\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Booking;
$router->get('/', function () use ($router) {
    return $router->app->version() . " - FPro";
});
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

// national
$router->group(['prefix' => 'admin/national'], function ($router){
    $router->get('/test', 'NationalController@test');
    $router->get('/list', 'NationalController@listNational');
    $router->get('/list/{id}', 'NationalController@listNational_ID');
    $router->post('/add', 'NationalController@addNational');
    $router->put('/update/{id}', 'NationalController@updateNational');
    $router->delete('/delete/{id}', 'NationalController@deleteNational');
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
// $router->group(['prefix' => 'admin/schedule'], function ($router){
//     $router->get('/list', 'ScheduleController@listSchedule');
//     $router->get('/list/{id}', 'ScheduleController@listSchedule_ID');
//     $router->post('/add', 'ScheduleController@addSchedule');
//     $router->put('/update/{id}', 'ScheduleController@updateSchedule');
//     $router->delete('/delete/{id}', 'ScheduleController@deleteSchedule');
// });
// Histories
$router->group(['prefix' => 'admin/histories'], function ($router){
    $router->get('/list', 'HistoriesController@listHistories');
    $router->get('/list/{id}', 'HistoriesController@listHistories_ID');
    $router->post('/add', 'HistoriesController@addHistories');
    $router->put('/update/{id}', 'HistoriesController@updateHistories');
    $router->delete('/delete/{id}', 'HistoriesController@deleteHistories');
});

$router->post("/auto-pull", function() {
    $shell = shell_exec("cd /var/www/html/be-dant-2 && git pull origin main");
    return response()->json($shell, 200);
});


$router->get("/hello", function(){

    $now = date("Y-m-d"); 

    $emailList = DB::table('bookings')
    ->select("users.email","users.name","bookings.id","timeslots.interval","timeslots.time_start","timeslots.time_end")
    ->join('schedules','schedules.id', "=",'bookings.schedule_id')
    ->join('users','users.id', "=", 'bookings.user_id')
    ->join("timeslots", "timeslots.id", "=", "schedules.timeslot_id")
    ->where("schedules.date" , $now)
    ->get();

    foreach ($emailList as $v) {

        $booking = DB::table('bookings')
        ->select("users.email","users.name","bookings.id","timeslots.interval","timeslots.time_start","timeslots.time_end")
        ->join('schedules','schedules.id', "=",'bookings.schedule_id')
        ->join('users','users.id', "=", 'bookings.user_id')
        ->join("timeslots", "timeslots.id", "=", "schedules.timeslot_id")
        ->where("bookings.id", $v->id)
        ->first();
    
    }

    $dataEmail = [];
            
    foreach ($emailList as $v) {

        $dataEmail['email'][] = $v->email;
    
    }

    Mail::send('email.booking', compact('booking'), function ($email) use ($dataEmail) {
        $email->subject('T&PTimes - Tin HOT nè');
        $email->to($dataEmail['email']);            
    });
    
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


