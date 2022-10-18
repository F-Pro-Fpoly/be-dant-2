<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class National extends Model
{
    // use HasFactory;
    protected $table = "nationals";
    protected $fillable = [
        'code',
        'name',
        'slug'
    ];
    public function searchNational($input = []){
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
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=",$input['code']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }
}
