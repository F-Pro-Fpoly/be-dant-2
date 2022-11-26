<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class National extends BaseModel
{
    // use HasFactory;
    protected $table = "nationals";
    protected $fillable = [
        'code',
        'name',
        'slug',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];
    public function searchNational($input = []){
        $query = $this->model();
        if(!empty($input['name'])){
            $query->where('name', 'like', "%{$input['name']}%");
        }
        if(!empty($input['slug'])){
            $query->where('slug', $input['slug']);
        }
        if(!empty($input['code'])){
            $query->where('code', $input['code']);
        }

        if(!empty($input['limit'])){
            return $query->paginate($input['limit']);
        }else{
            return $query->get();
        }
    }
}
