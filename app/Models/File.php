<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'alt',
        'url',
        'deleted',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function searchFile($input = []){
        $dataInput =[];
        if(!empty($input['id'])){
            $dataInput[] = [
                'id' , "like", "%".$input['id']."%"
            ];
        }
        if(!empty($input['alt'])){
            $dataInput[] = [
                'alt' , "like", "%".$input['alt']."%"
            ];
        }
        if(!empty($input['url'])){
            $dataInput[] = [
                'url' , "=",$input['url']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

    public function specialist(){
        return $this->hasOne(Specialist::class, 'thumbnail_id');
    }

}
