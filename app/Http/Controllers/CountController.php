<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Department;
use App\Models\File;
use App\Models\Histories;
use App\Models\National;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Sick;
use App\Models\Specialist;
use App\Models\status;
use App\Models\Timeslot;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;

class CountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function count(){
            $count = User::count();
            $booking = Booking::count();
            $department = Department::count();  
            $file = File::count(); 
            $historie = Histories::count();
            // $migration= Migrations
            $national = National::count();
            // $page = Pages
            $role = Role::count();
            $schedule = Schedule::count();
            $sick = Sick::count();
            $specialist = Specialist::count();
            $status = status::count();
            $timeslot = Timeslot::count();
            $vaccine = Vaccine::count();

            try{
                    return response()->json([
                        'data' => [
                            'user-count' => $count,
                            'booking-count' => $booking, 
                            'Department-count' => $department,
                            'file-count' => $file,
                            'historie-count' => $historie,
                            
                            'national-count' => $national,
                            'roles-count' => $role,
                            'schedule-count' => $schedule,
                            'sick-count' => $sick,
                            'specialist-count' => $specialist,
                            'status-count' => $status,
                            'timeslot-count' => $timeslot,
                            'vaccine-count' => $vaccine


                        ]
                    ]);
            } catch(\Throwable $th){
                return response()->json([
                    'message' => "Lỗi phía server",
                    'data' => $th->getMessage()
                ],400);
            }
      
        }

}
