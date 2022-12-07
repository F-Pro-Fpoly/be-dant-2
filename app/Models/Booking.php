<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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
        'description',
        'infoAfterExamination',
        'reasonCancel',
        'is_vaccine',
        'vaccine_code',
        'id_file',
        'email',
        'status_code',
        'payment_method',
        'address',
        'specialist_id',
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
        if(!empty($input['date'])){
            $dataInput[] = [
                'date' , "=" ,$input['date']
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


    public function searchBookingDoctor(array $input) {
      
        $query = $this->model();

        if(!empty($input['user_id'])) {
            $query->where('doctor_id', '=', $input['user_id']);
        }
        if(!empty($input['code'])) {
            $query->where('code', '=', $input['code']);
        }
        
        if(!empty($input['is_vaccine'])) {
            if($input['is_vaccine'] == 'vaccine') {
                $query->where('is_vaccine', 1)->orWhereNull('doctor_id', );
            }elseif ($input['is_vaccine'] == 'booking') {
                $query->where('is_vaccine', 0);
            }
        }

        if(!empty($input['date'])) {
            $date = $input['date'];
          
            $query->where(function($query) use($date) {    
                $query->whereHas('schedule', function ( $query) use ($date) {
                    $query->where('date', '=', $date);
                });     
            }); 
        }
        
        if(!empty($input['status'])) {
            $query->where('status_id', '=', $input['status']);
        }
        $query->orderBy('created_at','DESC');
        if(!empty($input['limit'])){
            return $query->paginate($input['limit']);
        }else{
            return $query->get();
        }
    }

    public function searchBookingPariend(array $input) {
      
        $query = $this->model();

        if(!empty($input['user_id'])) {
            $query->where('user_id', '=', $input['user_id']);
        }

        if(isset($input['is_vaccine'])) {
            $query->where('is_vaccine', '=', $input['is_vaccine']);
        }
       
        $query->orderBy('created_at','DESC');
        if(!empty($input['limit'])){
            return $query->paginate($input['limit']);
        }else{
            return $query->get();
        }
    }

    public function searchBookingDoctor_v2(array $input) {
      
        $query = $this->model();

        // if(!empty($input['user_id'])) {
        //     $query->where('doctor_id', '=', $input['user_id']);
        // }

        if(!empty($input['is_vaccine'])) {
            if($input['is_vaccine'] == 'vaccine') {
                if(!empty($input['user_id'])) {
                    $doctor_id = $input['user_id'];
                    $query->where(function($query) use ($doctor_id) {
                        $query->where('doctor_id', $doctor_id);
                    });
                }
            }elseif ($input['is_vaccine'] == 'booking') {
                $query->where('is_vaccine', 0);
            }
        }

        if(!empty($input['code'])) {
            $query->where('code', '=', $input['code']);
        }
        
        if(!empty($input['is_vaccine'])) {
            if($input['is_vaccine'] == 'vaccine') {
                $query->where('is_vaccine', 1)->orWhereNull('doctor_id');
            }elseif ($input['is_vaccine'] == 'booking') {
                $query->where('is_vaccine', 0);
            }
        }

        if(!empty($input['date'])) {
            $date = $input['date'];
          
            $query->where(function($query) use($date) {    
                $query->whereHas('Injection_info', function ( $query) use ($date) {
                    $query->where('time_apointment', '=', $date);
                });     
            }); 
        }
        
        if(!empty($input['status'])) {
            $query->where('status_id', '=', $input['status']);
        }
        $query->orderBy('created_at','DESC');
        if(!empty($input['limit'])){
            return $query->paginate($input['limit']);
        }else{
            return $query->get();
        }
    }
   

    public function searchMyBooking(array $input, $id){  

        $query = $this->model();

        if(!empty($input['user_id'])) {
            $query->where('doctor_id', '=', $input['user_id']);
        }
        

        if(!empty($input['date'])) {
            $date = $input['date'];
          
            $query->where(function($query) use($date) {    
                $query->whereHas('schedule', function ( $query) use ($date) {
                    $query->where('date', '=', $date);
                });     
            }); 
        }
        
        if(!empty($input['status'])) {
            $mang  =  $input['status'];
            $mang_tmp = explode(",", $mang);

            $query->where(function ($q) use ($mang_tmp) {       
            foreach($mang_tmp as $key => $v) {           
                if($key > 0){
                    $q->orWhere('status_id', '=', $v);
                }else{
                    $q->where('status_id', '=', $v);
                }
           
            }
         });
            
        }
        $query->where('user_id', '=', $id);
        if(!empty($input['department_id'])){
            $query->where('department_id', '=', $input['department_id']);
        }
        if(!empty($input['schedule_id'])){
            $query->where('schedule_id', '=', $input['schedule_id']);
        }
        if(!empty($input['code'])){
            $query->where('code', '=', $input['code']);
        }

        $query->orderBy('created_at','DESC');
        if(!empty($input['limit'])){
            return $query->paginate($input['limit']);
        }else{
            return $query->get();
        }

    }


    public function Injection_info()
    {
       return $this->hasMany(Injection_info::class, "booking_id", 'id');
    }
    public function vaccine()
    {
       return $this->belongsTo(Vaccine::class, "vaccine_code", 'code');
    }

 
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id', 'id');
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

    public function specialist(){
        return $this->belongsTo(Specialist::class , 'specialist_id', 'id');
    }


    public function file(){
        return $this->belongsTo(File::class, 'id_file');
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
        if(!empty($input['specialist_id'])){
            $this->specialist_id = $input['specialist_id'];
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
        if(!empty($input['description'])) {
            $this->description = $input['description'];
        }
        if(!empty($input['email'])){
            $this->email = $input['email'];
        }

        $this->save();
    }

}
