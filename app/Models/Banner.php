<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'status',
        'description',
        'thumnail_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function searchBanner($input=[])
    {
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
        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "like", "%".$input['name']."%"
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


    public function file(){
        return $this->belongsTo(File::class, 'thumnail_id');
    }
}

