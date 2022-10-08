<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends BaseModel
{

    protected $fillable = ['name', 'code', 'specialist_id', 'description'];

    public function booking(){
        return $this->hasMany(booking::class, 'department_id');
    }
}
