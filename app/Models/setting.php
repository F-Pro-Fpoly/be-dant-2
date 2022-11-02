<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'description',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function searchSetting($input = []){
        $dataInput = [];
        if(!empty($input['code'])){
            $dataInput[] = [
                'code'  , "=", $input['code']
            ];
        }
        if(!empty($input['status'])){
            $dataInput[] = [
                'status' , "=", $input['status']
            ];
        }
        if(!empty($input['description'])){
            $dataInput[] = [
                'description' , "like", "%".$input['description']."%"
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }


}
