<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends BaseModel
{

    protected $fillable = [
        'name', 'code', 'specialist_id', 'description', 'active',
        'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_at',
        'deleted_by', 'deleted'
    ];

    public function booking(){
        return $this->hasMany(booking::class, 'department_id');
    }

    public function specialist(){
        return $this->belongsTo(Specialist::class);
    }

    public function user() {
        return $this->hasOne(User::class, 'deleted_by', 'id');
    }


    public function searchDepartment($input = []){
        $dataInput =[];
        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "like", "%".$input['name']."%"
            ];
        }
        if(!empty($input['specialist_id'])){
            $dataInput[] = [
                'specialist_id' , "=", $input['specialist_id']
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
