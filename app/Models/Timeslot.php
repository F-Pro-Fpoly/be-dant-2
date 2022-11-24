<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'time_start',
        'time_end',
        'interval',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    // public function booking(){
    //     return $this->hasMany(Booking::class, 'timeSlot_id');
    // }
    // public function timeslotDetail() {
    //     return $this->hasMany(TimeslotDetail::class, "timeslot_id" ,"id");
    // }

    public function schedules() {
        return $this->hasMany(Schedule::class, "timeslot_id" ,"id");       
    }

    public function searchTimeSlot(array $input) {
        $query = $this->model();

        if(!empty($input['date'])) {
            $date = $input['date'];
            $doctor_id = $input['doctor_id']??null;
            $query->where(function($query) use($date, $doctor_id) {
                $query->whereDoesntHave('schedules', function (Builder $query) use ($date, $doctor_id) {
                    $query->where('date', '=', $date)->where('doctor_id', $doctor_id);
                });
            });
        }

        if(!empty($input['interval'])) {
            if($input['interval'] != 'M' && $input['interval'] != 'A') {
                throw new \Exception('Bạn phải nhập khoản thời gian giá trị là M va A', 400);
            }

            $query->where('interval', $input['interval']);
        }

        if(!empty($input['limit'])){
            return $query->limit($input['limit'])->paginate();
        }else{
            return $query->get();
        }
    }
    
}
