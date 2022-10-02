<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Histories extends Model
{
    protected $table = 'histories';
    protected $fillable = ['file', 'date_examination', 'description', 'doctor_id', 'patient_id'];
}
