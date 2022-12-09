<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class booking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    
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
            $email->subject('FPRO - THÔNG BÁO ĐẾN BẠN');
            $email->to($dataEmail['email']);            
        });


    }
}
