<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'code',
        'department_id', 
        'schedule_id',
        'user_id',
        'doctor_id',
        'status_id',
        'status_code',
        'payment_method',
        'address',
        'city_code',
        'customer_name',
        'type',
        'phone',
        'birthday',
        'district_code',
        'price',
        'ward_code',
        'status_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function searchBooking($input = []){
        $dataInput =[];
        if(!empty($input['department_id'])){
            $dataInput[] = [
                'department_id' , "=" ,$input['department_id']
            ];
        }
        if(!empty($input['schedule_id'])){
            $dataInput[] = [
                'schedule_id' , "=" ,$input['schedule_id']
            ];
        }
        // if(!empty($input['timeSlot_id'])){
        //     $dataInput[] = [
        //         'timeSlot_id' , "=" ,$input['timeSlot_id']
        //     ];
        // }
        if(!empty($input['user_id'])){
            $dataInput[] = [
                'user_id' , "=" ,$input['user_id']
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

    public function searchMyBooking($input = [], $id, $with=[] ,$limit = null){  
        $dataInput =[];
        if(!empty($input['department_id'])){
            $dataInput[] = [
                'department_id' , "=" ,$input['department_id']
            ];
        }
        if(!empty($input['schedule_id'])){
            $dataInput[] = [
                'schedule_id' , "=" ,$input['schedule_id']
            ];
        }
        $dataInput[] = [
            'user_id' , "=" , $id
        ];
        // if(!empty($input['timeSlot_id'])){
        //     $dataInput[] = [
        //         'timeSlot_id' , "=" ,$input['timeSlot_id']
        //     ];
        // }
        if(!empty($input['user_id'])){
            $dataInput[] = [
                'user_id' , "=" ,$input['user_id']
            ];
        }
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=",$input['code']
            ];
        }
        $data = $this->search($dataInput, [], $limit);
        return $data;
    }


 
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id','id');
    }

    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

    public function status(){
        return $this->belongsTo(status::class , 'status_id', 'id');
    }

    public function create_booking($input) {
        if(!empty($input['code'])) {
            $this->code = $input['code'];
        }
        if(!empty($input['department_id'])){
            $this->department_id = $input['department_id'];
        }
        if(!empty($input['schedule_id'])) {
            $this->schedule_id = $input['schedule_id'];
        }
        if(!empty($input['user_id'])){
            $this->user_id = $input['user_id'];
        }
        if(!empty($input['doctor_id'])) {
            $this->doctor_id = $input['doctor_id'];
        }
        if(!empty($input['status_id'])) {
            $this->status_id = $input['status_id'];
        }
        if(!empty($input['status_code'])) {
            $this->status_code = $input['status_code'];
        }
        if(!empty($input['payment_method'])) {
            $this->payment_method = $input['payment_method'];
        }
        if(!empty($input['address'])){
            $this->address = $input['address'];
        }
        if(!empty($input['city_code'])) {
            $this->city_code = $input['city_code'];
        }
        if(!empty($input['customer_name'])) {
            $this->customer_name = $input['customer_name'];
        }
        if(!empty($input['type'])) {
            $this->type = $input['type'];
        }
        if(!empty($input['phone'])) {
            $this->phone = $input['phone'];
        }
        if(!empty($input['birthday'])){
            $this->birthday = $input['birthday'];
        }
        if(!empty($input['district_code'])) {
            $this->district_code = $input['district_code'];
        }
        if(!empty($input['price'])){
            $this->price = $input['price'];
        }
        if(!empty($input['ward_code'])) {
            $this->ward_code = $input['ward_code'];
        }
        if(!empty($input['created_by'])) {
            $this->created_by = $input['created_by'];
        }

        $this->save();
    }

}
