<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends BaseModel
{
    protected $fillable = [
        'code',
        'date',
        'description',
        'doctor_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function booking(){
        return $this->hasMany(booking::class, 'schedule_id');
    }

    public function doctor() {
        return $this->belongsTo(User::class, "doctor_id", 'id');
    }

    public function searchSchedule($input = []){
        $dataInput =[];
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=",$input['code']
            ];
        }
        if(!empty($input['sort'])) {
            $sort = [$input['sort'], 'desc'];
        }
        // if(!empty($input['department_id'])) {
        //     $dataInput[] = [
        //         'department_id' , "=",$input['department_id']
        //     ];
        // }
        $data = $this->search($dataInput, [], 5, $sort??null);
        return $data;
    }
}
