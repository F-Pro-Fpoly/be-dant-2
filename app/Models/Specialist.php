<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends BaseModel
<<<<<<< HEAD
{
    protected $table = 'specialists';
=======
{   
>>>>>>> 9a565c0ca4b5aad2da5a289b0d1ddabf9e05ebe9
    protected $fillable = [
        'code',
        'name',
        'slug',
        'description',
<<<<<<< HEAD
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];
    
=======
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
>>>>>>> 9a565c0ca4b5aad2da5a289b0d1ddabf9e05ebe9
}
