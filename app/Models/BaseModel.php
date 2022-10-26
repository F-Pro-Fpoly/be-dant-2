<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    use SoftDeletes ;


    protected function search($input, $with = [], $limit = null) {
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

        // dd($query->toSql());

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
}
