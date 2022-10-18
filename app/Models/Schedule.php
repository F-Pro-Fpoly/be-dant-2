<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['code', 'date', 'description', 'department_id'];

    public function booking(){
        return $this->hasMany(booking::class, 'schedule_id');
    }
    public function searchSchedule($input = []){
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
