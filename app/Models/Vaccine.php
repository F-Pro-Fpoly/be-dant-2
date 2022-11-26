<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'code',
        'slug',
        'description',
        'price',
        'img_id',
        'is_active',
        'sick_ids',
        'sick_id',
        'category_ids',
        'national_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function searchVaccine($input = []){
        $dataInput =[];
        if(!empty($input['name'])){
            $dataInput[] = [
                'email' , "like", "%".$input['email']."%"
            ];
        }
        if(!empty($input['slug'])){
            $dataInput[] = [
                'slug' , "like", "%".$input['slug']."%"
            ];
        }
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=",$input['code']
            ];
        }
        if(!empty($input['price'])){
            $dataInput[] = [
                'price' , "=",$input['price']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }
}
