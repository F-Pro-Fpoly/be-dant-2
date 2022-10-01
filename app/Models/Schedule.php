<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $fillable = ['code', 'date', 'description', 'department_id'];
}
