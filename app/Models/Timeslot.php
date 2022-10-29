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
    public function timeslotDetail() {
        return $this->hasMany(TimeslotDetail::class, "timeslot_id" ,"id");
    }

    public function searchTimeSlot(array $input) {
        $query = $this->model();

        if(!empty($input['schedule_id'])) {
            $schedule_id = $input['schedule_id'];
            $query->whereDoesntHave('timeslotDetail', function (Builder $query) use ($schedule_id) {
                $query->where('schedule_id', '=', $schedule_id);
            });
        }

        if(!empty($input['limit'])){
            return $query->limit($input['limit'])->paginate();
        }else{
            return $query->get();
        }
    }
    
}
