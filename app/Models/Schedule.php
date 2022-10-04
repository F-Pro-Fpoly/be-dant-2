<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['code', 'date', 'description', 'department_id'];

    public function booking(){
        return $this->hasMany(booking::class, 'schedule_id');
    }
}
