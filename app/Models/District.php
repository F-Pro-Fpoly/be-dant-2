<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends BaseModel
{
    protected $table = "districts";
    protected $fillable = [
        'code',
        'type',
        'name',
        'id_district_vnp',
        'name_district_vnp',
        'full_name',
        'description',
        'city_id',
        'city_code',
        'is_active',
        'code_ghn',
        'deleted',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function city() {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }

    public function search_district(array $input = []) {
        $query = $this->model();

        if(isset($input['code'])) {
            $query->where('code', $input['code']);
        }

        if(isset($input['city_id'])) {
            $query->where('city_id', $input['city_id']);
        }

        if(isset($input['city_code'])){
            $query->where('city_code', $input['city_code']);
        }

        if(isset($input['name'])) {
            $query->where('name', 'like', "%{$input['name']}%");
        }

        if(isset($input['type'])) {
            $query->where('type', $input['type']);
        }

        if(isset($input['limit'])) {
            return $query->panigate($input['limit']);
        }else{
            return $query->get();
        }
    }
}
