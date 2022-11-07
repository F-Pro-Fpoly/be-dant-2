<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_category extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'code',
        'slug', 
        'status',
        'name',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function searchNews_category($input = []){
        $dataInput =[];
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=" ,$input['code']
            ];
        }
        if(!empty($input['status'])){
            $dataInput[] = [
                'status' , "=" ,$input['status']
            ];
        }
        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "=",$input['name']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

 
    public function user(){
        return $this->belongsTo(User::class);
    }

}
