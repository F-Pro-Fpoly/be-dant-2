<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Injection_info extends BaseModel {
    protected $table = "injection_info";

    protected $fillable = [
        'type',
        'time_apointment',
        'status_code',
        'booking_id',
        'booking_code',
        'file_id',
        'description',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];
}