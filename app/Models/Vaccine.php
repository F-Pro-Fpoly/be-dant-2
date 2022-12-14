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

    public function file() {
        return $this->belongsTo(File::class, 'img_id', 'id');
    }

    public function booking()
    {
       return $this->hasMany(Booking::class, 'vaccine_code', 'code');
    }

    public function national() {
        return $this->belongsTo(National::class, 'national_id', 'id');
    }

    public function searchVaccine($input = [], $limit = null){
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
        if(!empty($input['is_active'])){
            $dataInput[] = [
                'is_active' , "=",$input['is_active']
            ];
        }
        if(!empty($input['price'])){
            $dataInput[] = [
                'price' , "=",$input['price']
            ];
        }
        $data = $this->search($dataInput, [],$limit);
        return $data;
    }
}
