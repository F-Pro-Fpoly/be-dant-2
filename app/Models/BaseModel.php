<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes ;


    protected function search($input, $with = [], $limit) {
        $query = $this->make();
        if(empty($input)){
            if(!empty($limit)){
                return $this->paginate($limit);
            }else{
                return $this->get();
            }
        }

        // dd(123);

        $query = $query->where(function($query) use ($input) {

            foreach($input as $key => $val){
                $query->where($val[0], $val[1], $val[2]);
            }
        });

        // dd($query->toSql());


        return $query->paginate($limit);
    }
}
