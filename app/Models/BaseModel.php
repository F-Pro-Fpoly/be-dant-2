<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    use SoftDeletes ;


    protected function search($input, $with = [], $limit = null, $sort = null) {
        $query = $this->make();
        if(empty($input)){
            if(!empty($limit)){
                return $this->paginate($limit);
            }else{
                return $this->get();
            }
        }

        $query = $query->where(function($query) use ($input) {

            foreach($input as $key => $val){
                $query->where($val[0], $val[1], $val[2]);
            }
        });

        if(!empty($sort)){
            // ['name', 'desc']
            // dd($query->toSql());
             $query->orderBy($sort[0], $sort[1]);
        }

        if($limit == null){
            return $query->get();
        }
        return $query->paginate($limit);
    }

    public static final function model()
    {
        $classStr = get_called_class();
        /** @var Model $class */
        $class = new $classStr();
        return $class::whereNull($class->getTable() . '.deleted_at');
    }
    
    public function delete()
    {
        if(Schema::hasColumn($this->table,  "deleted")){
            $this->deleted = 1;
        }

        if(Schema::hasColumn($this->table, "deleted_by")){
            $this->deleted_by = auth()->user()->id;
        }
        $this->save();
        parent::delete();
    }

    
    public function sortBuilder(&$query, $attributes = [])
    {
    $validConditions = ['asc', 'desc'];
    $validColumn     = DB::getSchemaBuilder()->getColumnListing($this->getTable());

    if (empty($attributes['sort'])) {
        $attributes['sort'] = ['updated_at' => 'asc'];
    }
    foreach ($attributes['sort'] as $key => $value) {

        if (!$value) {
            $value = 'asc';
        }

        if (!in_array($value, $validConditions)) {
            continue;
        }

        if (!in_array($key, $validColumn)) {
            continue;
        }
        $query->orderBy($key, $value);
    }
}
}
