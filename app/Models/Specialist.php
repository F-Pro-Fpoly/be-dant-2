<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends BaseModel
{   
    protected $fillable = [
        'code',
        'name',
        'slug',
        'description',
        'created_by',
        'updated_by',
        "deleted_by",
    ];

    public function searchSpecialist($input = []){
        $dataInput =[];
        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "like", "%".$input['name']."%"
            ];
        }
        if(!empty($input['slug'])){
            $dataInput[] = [
                'slug' , "like", "%".$input['slug']."%"
            ];
        }
        if(!empty($input['description'])){
            $dataInput[] = [
                'description' , "like", "%".$input['description']."%"
            ];
        }
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=",$input['code']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }
}
