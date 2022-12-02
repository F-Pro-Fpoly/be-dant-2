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

    public function booking()
    {
       return $this->belongsTo(Booking::class, "booking_id", 'id');
    }

    public function file() {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }

    public function status() {
        return $this->belongsTo(status::class, 'status_code', 'code');
    }

    public function update_injection_info(array $input = []) {
        if(!empty($input['status_id'])) {
            $status_code = status::where('id', $input['status_id'])->value('code');
            $this->status_code = $status_code;
        }
        if(!empty($input['file_id'])) {
            $this->file_id = $input['file_id'];
        }

        if(!empty($input['description'])) {
            $this->description = $input['description'];
        }

        $this->save();
    }

}

