<?php

namespace App\Models;

use DateTime;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'avatar', 'address', 'phone', 'active', 'role_id',
        "created_at", "created_by", "updated_at", "updated_by" ,"deleted", "deleted_at", "deleted_by",
        "date", "gender", 'specailist_id', 'specailist_code', 'user_info', 'city_code', 'city_id',
        'district_code', 'district_id', 'ward_code', 'ward_id', 'birthday'       
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function booking(){
        return $this->hasMany(booking::class, 'user_id');
    }

    public function specialist(){
        return $this->belongsTo(Specialist::class, 'specailist_id' ,'id');
    }

    public function department(){
        return $this->belongsTo(Department::class, 'department_id' ,'id');
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }

    public function district() {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    public function ward() {
        return $this->belongsTo(Ward::class, 'ward_code', 'code');
    }

    public function searchUser($input = []){
        $dataInput = [];
        if(!empty($input['email'])){
            $dataInput[] = [
                'email' , "like", "%".$input['email']."%"
            ];
        }
        if(!empty($input['name'])) {
            $dataInput[] = [
                'name' , "like", "%".$input['name']."%"
            ];
        }
        if(!empty($input['username'])) {
            $dataInput[] = [
                'username' , "like", "%".$input['username']."%"
            ];
        }
        if(!empty($input['role_code'])) {
            $role_id = Role::where("code", $input['role_code'])->value('id');
            $dataInput[] = [
                'role_id', '=', $role_id
            ];
            if(!empty($input['specailist_code'])) {
                $specailist_id = Specialist::model()->where('code', $input['specailist_code'])->value('id');
                $dataInput[] = [
                    'specailist_id', '=', $specailist_id
                ];
            }
            if(!empty($input['specailist_slug'])) {
                $specailist_id = Specialist::model()->where('slug', $input['specailist_slug'])->value('id');
                // dd($specailist_id);
                $dataInput[] = [
                    'specailist_id', '=', $specailist_id
                ];
            }
        }

        if(!empty($input['department_id'])) {
            $dataInput[] = [
                'department_id', '=', null
            ];
        }
        
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

    public function searchUserV2(array $input = []) {
        $query = $this->model();

        if(!empty($input['name'])) {
            $query->where('name', 'like', "%{$input['name']}%");
        }
        if(!empty($input['code'])) {
            $query->where('code', $input['code']);
        }
        if(!empty($input['username'])){
            $query->where('username', $input['username']);
        }
        if(!empty($input['email'])) {
            $query->where('email', 'like', "%{$input['email']}%");
        }
        if(!empty($input['role_id'])) {
            $query->where('role_id', $input['role_id']);
        }
        if(!empty($input['role_code'])) {
            $role_id = Role::where('code', $input['role_code'])->value('id');
            $query->where('role_id', $role_id);
        }

        if(!empty($input['limit'])) {
            return $query->paginate($input['limit']);
        }
        else{
            return $query->get();
        }
    }

    public function updateUser(array $input = [])
    {
      
        if(count($input) <= 0){
            throw new HttpException(400, "Cần nhập thông tin update");
        }

        if(!empty($input['address'])){
            $this->address = $input['address'];
        }

        if(!empty($input['birthday'])) {
            $this->birthday = $input['birthday'];
        }

        if(!empty($input['phone'])){
            $this->phone = $input['phone'];
        }
        if(!empty($input['password'])){
            $this->password = Hash::make($input['password']);
        }

        if(!empty($input['name'])){
            $this->name = $input['name'];
        }

        if(!empty($input['role_id'])) {
            $this->role_id = $input['role_id'];
        }
        if(!empty($input['date'])) {
            $this->date = $input['date'];
        }
        if(!empty($input['gender'])) {
            $this->gender = $input['gender'];
        }
        if(!empty($input['user_info'])) {
            $this->user_info = $input['user_info'];
        }

        if(!empty($input['department_id'])) {
            $this->department_id = $input['department_id'];
            if($input['department_id'] == "null") {
                $this->department_id = null;
            }
        }
        
        if(!empty($input['city_code'])) {
            $this->city_code = $input['city_code'];
        }

        if(!empty($input['district_code'])) {
            $this->district_code = $input['district_code'];
        }

        if(!empty($input['ward_code'])) {
            $this->ward_code = $input['ward_code'];
        }

        if(!empty($input['active'])) {
            $this->active = $input['active'];
        }

        if(isset($input['active'])) {
            if($input['active'] == 0) {
                $this->active = $input['active'];
            }
        }
        
        $id = auth()->user()->id ?? null;
        if(!empty($id)) {
            $this->updated_by = auth()->user()->id;
        }
        $this->save();
    }

    public function get_data_schudule (array $input = []) {
        $datetime = new \DateTime('tomorrow');
        if(isset($input['date'])) {
            $date = date_format(new DateTime($input['date']), 'Y-m-d');
            // dd($date);
        }else{
            $date = $datetime->format('Y-m-d');
        }
        $time_slot = [];
        $doctor_id = $this->id;
        $schedule_dates = [];
        $date_v2 = $datetime->format('Y-m-d');
        // dd(gettype($date_v2));
        $schedulesV0 = Schedule::select('date')->where('date', '>=' , $date_v2)->where('doctor_id', $doctor_id)
            ->groupBy('date')->orderBy('date', 'asc')
            ->limit(5)->get();
        foreach($schedulesV0 as $scheduleV0) {
            $schedule_dates[] = [
                'date' => $scheduleV0->date,
                'date_format' => date_format(new DateTime($scheduleV0->date), 'D d/m')
            ];
        }
        // dd($schedule_dates);

        $schedules = Schedule::where('date', $date)->where('doctor_id', $doctor_id)
            ->where('status_code', 'STILLEMPTY')
            ->get();
        
        foreach ($schedules as $key => $schedule) {
            $time_slot[] = [
                'time_start' => \Carbon\Carbon::createFromFormat('H:i:s',$schedule->timeslot->time_start)->format('h:i'),
                'time_end' => \Carbon\Carbon::createFromFormat('H:i:s',$schedule->timeslot->time_end)->format('h:i'),
                'status_code'=>$schedule->status_code,
                'status_id' => $schedule->status_id,
                'id' => $schedule->id
            ];
        }

        

        $schudule_data = [
            'schedule_date' => $date,
            'schedule_dates' => $schedule_dates,
            'schedule_data' => $time_slot
        ];

        return $schudule_data;
    }
}
