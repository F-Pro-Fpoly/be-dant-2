<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends BaseModel
{
    protected $table = 'department';
    protected $fillable = ['name', 'code', 'specialist_id', 'description'];
}
