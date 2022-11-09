<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug',
        'font',
        'status',
        'sort',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function searchPage($input = []){
        $dataInput = [];

        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "like", "%".$input['name']."%"
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }


}
