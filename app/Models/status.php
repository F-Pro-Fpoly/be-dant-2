<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'deleted_at',
    ];

    public function booking(){
        return $this->hasOne(Booking::class, 'status_id');
    }

    public function contact(){
        return $this->hasOne(contact::class, 'status_id');
    }
}
