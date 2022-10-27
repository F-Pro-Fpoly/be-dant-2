<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends BaseModel
{

    protected $fillable = [
        'name', 'code', 'specialist_id', 'description', 'active',
        'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_at',
        'deleted_by', 'deleted'
    ];

    public function booking(){
        return $this->hasMany(booking::class, 'department_id');
    }

    public function specialist(){
        return $this->belongsTo(Specialist::class);
    }

    public function user() {
        return $this->hasOne(User::class, 'deleted_by', 'id');
    }


    public function searchDepartment($input = []){
        $dataInput =[];
        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "like", "%".$input['name']."%"
            ];
        }
        if(!empty($input['specialist_id'])){
            $dataInput[] = [
                'specialist_id' , "=", $input['specialist_id']
            ];
        }
        if(!empty($input['description'])){
            $dataInput[] = [
                'description' , "like", "%".$input['description']."%"
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

    public function updateDepartment(array $input) {
        if(!empty($input['name'])) {
            $this->name = $input['name'];
        }
        if(!empty($input['specialist_id'])) {
            $this->specialist_id = $input['specialist_id'];
        }

        if(!empty($input['description'])) {
            $this->description = $input['description'];
        }

        if(!empty($input['active'])) {
            $this->active = $input['active'];
        }
        $department_id = $this->id;
        // dd($department_id);
        $users = User::select('id')->where("department_id", $department_id)->get();
        $user_ids = [];
        foreach($users as $user) {
            $user_ids[] = $user->id;
        }
        foreach($user_ids as $id) {
            $us = User::findOrFail($id);
            $us->department_id = null;
            $us->save();
        }

        if(!empty($input['docters'])) {
            
            // dd(123);
            foreach($input['docters'] as $docters) {
                $user = User::where("username", $docters['doctor_name'])->first();
                // dd($user);
                $user->department_id = $department_id;
                $user->save();
            }
        }
        $this->updated_by = auth()->user()->id;
        $this->save();
    }

}
