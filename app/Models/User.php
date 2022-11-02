<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        "date", "gender"
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
        }
        if(!empty($input['department_id'])) {
            $dataInput[] = [
                'department_id', '=', null
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

    public function updateUser(array $input = [])
    {
        if(count($input) <= 0){
            throw new HttpException(400, "Cần nhập thông tin update");
        }

        if(!empty($input['address'])){
            $this->address = $input['address'];
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

        if(!empty($input['department_id'])) {
            $this->department_id = $input['department_id'];
            if($input['department_id'] == "null") {
                $this->department_id = null;
            }
        }
        

        if(!empty($input['active'])) {
            $this->active = $input['active'];
        }else{
            $this->active = 0;
        }
        $this->updated_by = auth()->user()->id;
        $this->save();
    }
}
