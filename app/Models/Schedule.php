<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends BaseModel
{
    protected $fillable = [
        'code',
        'date',
        'description',
        'timeslot_id',
        'status_id',
        'status_code',
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

    public function timeslot() {
        return $this->belongsTo(Timeslot::class, "timeslot_id", "id");
    }

    public function status() {
        return $this->belongsTo(status::class, "status_code", "code");
    }

    public function searchSchedule($input = []){
        $query = $this->model();
        // if(!empty($input['code'])){
        //     $dataInput[] = [
        //         'code' , "=",$input['code']
        //     ];
        // }
        if(!empty($input['created_by'])) {
            $query->where("created_by", $input['created_by']);
        }
        if(!empty($input['date'])) {
            // dd($input['date']);    
            $query->where('date', '=', $input['date']);
        }
        if(!empty($input['sort'])) {
            $sort = [$input['sort'], 'desc'];
        }
        
        // if(!empty($input['department_id'])) {
        //     $dataInput[] = [
        //         'department_id' , "=",$input['department_id']
        //     ];
        // }
        // $data = $this->search($dataInput, [], null, $sort??null);
        // dd($query->toSql());
        if(!empty($input['limit'])) {
            $data = $query->panigate($input['limit']);
        }else{
            $data = $query->get();
        }
        return $data;
    }
}
