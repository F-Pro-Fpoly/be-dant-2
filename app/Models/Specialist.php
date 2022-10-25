<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends BaseModel

{
    protected $table = 'specialists';
    protected $fillable = [
        'id',
        'code',
        'name',
        'slug',
        'description',
        'status',
        'thumbnail_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];


    public function department(){
        return $this->hasOne(Department::class);
    }

    // public function file(){
    //     return $this->belongsTo(File::class, 'thumbnail_id');
    // }
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
