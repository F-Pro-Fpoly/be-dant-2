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
    
}
