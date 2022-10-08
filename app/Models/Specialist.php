<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends BaseModel
{
    protected $table = 'specialists';
    protected $fillable = [
        'code',
        'name',
        'slug',
        'description',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
    
}
