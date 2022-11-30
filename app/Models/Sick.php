<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sick extends BaseModel
{
    use HasFactory;

    protected $table = "sicks";

    protected $fillable = [
        'name', 
        'code',
        'slug',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public function searchSick(array $input = []){
        $dataInput =[];
        // if(!empty($input['name'])){
        //     $dataInput[] = [
        //         'name' , "like", "%".$input['name']."%"
        //     ];
        // }
        // if(!empty($input['slug'])){
        //     $dataInput[] = [
        //         'slug' , "like", "%".$input['slug']."%"
        //     ];
        // }
        // if(!empty($input['code'])){
        //     $dataInput[] = [
        //         'code' , "=",$input['code']
        //     ];
        // }
        // $data = $this->search($dataInput, [], 5);
        $query = $this->model();
        if(!empty($input['name'])) {
            $query->where('name', 'like', "%{$input['name']}%");
        }
        if(!empty($input['slug'])){
            $query->where('slug', 'like', "%{$input['slug']}%");
        }
        if(!empty($input['code'])){
            $query->where('code', $input['code']);
        }
        if(!empty($input['is_active'])) {
            $query->where('is_active', $input['is_active']);
        }
        if(!empty($input['limit'])){
            return $query->paginate($input['limit']);
        }else{
            return $query->get();
        }
    }

}
