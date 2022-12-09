<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaccine_category extends BaseModel
{
    use HasFactory;

    protected $table = "vaccines_category";

    protected $fillable = [
        'code',
        'name',
        'slug',
        'parent_id',
        'active',
        'description',
        'short_description',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function parent() {
        return $this->belongsTo(Vaccine_category::class, 'parent_id', 'id');
    }

    public function childrens() {
        return $this->hasMany(Vaccine_category::class, 'parent_id', 'id');
    }

    public function search_vaccine_category(array $input = []) 
    {
        $query = $this->model();
        if(!empty($input['code'])) {
            $query->where('code', $input['code']);
        }
        if(!empty($input['name'])){
            $query->where('name', 'like', "%{$input['name']}%");
        }

        $query->where('active', 1);
        if(!empty($input['parent_id'])) {
            $query->where('parent_id', $input['parent_id']);
        }
        if(isset($input['is_parent'])){
            $input['is_parent'] = filter_var($input['is_parent'], FILTER_VALIDATE_BOOL); 
            if((bool) $input['is_parent']){
                $query->whereNotNull('parent_id');
            }else{
                $query->whereNull('parent_id');
            }
        }

        if(!empty($input['limit'])) {
            $data = $query->paginate($input['limit']);
        }else{
            $data = $query->get();
        }

        return $data;
    }
}