<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends BaseModel
{
    protected $table = "cities";
    protected $fillable = [
        'code',
        'type',
        'name',
        'grab_code',
        'id_city_vnp',
        'name_city_vnp',
        'full_name',
        'description',
        'region_code',
        'region_name',
        'is_active',
        'deleted',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by'
    ];

    public function search_city(array $input = []) {
        $query = $this->model();

        if(isset($input['code'])) {
            $query->where('code', $input['code']);
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
