<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends BaseModel

{
    protected $table = 'specialists';
    protected $fillable = [
        'id',
        'code',
        'name',
        'slug',
        'short_description',
        'description',
        'is_feature',
        'status',
        'thumbnail_id',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];


    public function department(){
        return $this->hasOne(Department::class);
    }

    public function booking(){
        return $this->hasOne(Booking::class, 'specailist_id');
    }

    public function user(){
        return $this->hasMany(User::class, 'specailist_id' , 'id');
    }

    public function file(){
        return $this->belongsTo(File::class, 'thumbnail_id');
    }
    public function searchSpecialist($input = []){
        $query = $this->model();

        if(!empty($input['name'])) {
            $query->where('name', 'like', "%{$input['name']}%");
        }
        if(!empty($input['slug'])) {
            $query->where('slug', $input['slug']);
        }
        if(!empty($input['code'])) {
            $query->where('code', $input['code']);
        }
        if(!empty($input['status'])) {
            $query->where('status', $input['status']);
        }
        if(!empty($input['is_feature'])) {
            $query->where('is_feature', $input['is_feature']);
        }
        if(!empty($input['is_vaccine'])) {
            $query->where('code', '!=', 'vaccine');
        }
        if(!empty($input['limit'])) {
            return $query->paginate($input['limit']);
        }
        else{
            return $query->get();
        }
        // $dataInput =[];
        // if(!empty($input['name'])){
        //     $dataInput[] = [
        //         'name' , "like", "%".$input['name']."%"
        //     ];
        // }
        // if(!empty($input['slug'])){
        //     $dataInput[] = [
        //         'slug' , "like", "%".$input['slug']."%"
        //     ];
        // }
        // if(!empty($input['description'])){
        //     $dataInput[] = [
        //         'description' , "like", "%".$input['description']."%"
        //     ];
        // }
        // if(!empty($input['code'])){
        //     $dataInput[] = [
        //         'code' , "=",$input['code']
        //     ];
        // }
        // if(!empty($input['status'])){
        //     $dataInput[] = [
        //         'status' , "=" , $input['status']
        //     ];
        // }
        // if(!empty($input['is_feature'])){
        //     $dataInput[] = [
        //         'is_feature' , "=" , $input['is_feature']
        //     ];
        // }
        // if(!empty($input['limit'])){
        //     $data = $this->search($dataInput, [], $input['limit']);
        // }else{
        //     $data = $this->search($dataInput);
        // }
        // return $data;
    }
}
