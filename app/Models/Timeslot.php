<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'time_start',
        'time_end',
        'schedule_id',
    ];

    public function booking(){
        return $this->hasMany(Booking::class, 'timeSlot_id');
    }
    
}
