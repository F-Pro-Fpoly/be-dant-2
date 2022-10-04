<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'code',
        'department_id', 
        'schedule_id',
        'timeSlot_id',
        'user_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function searchBooking($input = []){
        $dataInput =[];
        if(!empty($input['department_id'])){
            $dataInput[] = [
                'department_id' , "=" ,$input['department_id']
            ];
        }
        if(!empty($input['schedule_id'])){
            $dataInput[] = [
                'schedule_id' , "=" ,$input['schedule_id']
            ];
        }
        if(!empty($input['timeSlot_id'])){
            $dataInput[] = [
                'timeSlot_id' , "=" ,$input['timeSlot_id']
            ];
        }
        if(!empty($input['user_id'])){
            $dataInput[] = [
                'user_id' , "=" ,$input['user_id']
            ];
        }
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=",$input['code']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

 
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

    public function timeslot(){
        return $this->belongsTo(Timeslot::class);
    }



}
