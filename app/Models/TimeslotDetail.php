<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeslotDetail extends BaseModel
{
    use HasFactory;
    protected $table = "timeslot_details";
    protected $fillable = [
        'schedule_id',
        'timeslot_id',
        'status_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
        'status_code'
    ];
    public function timeslot() {
        return $this->belongsTo(Timeslot::class, 'timeslot_id', 'id');
    }

    public function status() {
        return $this->belongsTo(status::class, 'status_code', 'code');
    }
}
