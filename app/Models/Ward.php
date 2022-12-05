<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends BaseModel
{
    protected $table = "wards";
    protected $fillable = [
        'code',
        'type',
        'name',
        'full_name',
        'id_ward_vnp',
        'name_ward_vnp',
        'ma_buu_chinh',
        'description',
        'district_code',
        'is_active',
        'deleted',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
        'code_ghn',
        'district_id',
        'district_code'
    ];

    public function district() {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function search_ward(array $input = []) {
        $query = $this->model();

        if(isset($input['code'])) {
            $query->where('code', $input['code']);
        }

        if(isset($input['district_code'])){
            $query->where('district_code', $input['district_code']);
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
