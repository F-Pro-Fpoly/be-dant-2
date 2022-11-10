<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends BaseModel
{
    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'email',
        'contents',
        'type',
        'phone',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];


    public function searchContact($input = []){
        $dataInput =[];
        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "like", "%".$input['name']."%"
            ];
        }
        if(!empty($input['email'])){
            $dataInput[] = [
                'email' , "like", "%".$input['email']."%"
            ];
        }
        if(!empty($input['contents'])){
            $dataInput[] = [
                'contents' , "like", "%".$input['contents']."%"
            ];
        }
        if(!empty($input['type'])){
            $dataInput[] = [
                'type' , "=",$input['type']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

}
