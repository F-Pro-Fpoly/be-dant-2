<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends BaseModel
{
    protected $table = 'contacts';
    protected $fillable = [
        'id',
        'name',
        'email',
        'contents',
        'reply_contact',
        'type',
        'phone',
        'id_contact_firebase',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];


    public function searchContact( array  $input){


        $query = $this->model();

        if(!empty($input['name'])) {
            $query->where('name', 'like', "%".$input['name']."%");
        }
        if(!empty($input['contents'])) {
            $query->where('contents', 'like', "%".$input['contents']."%");
        }
        if(!empty($input['email'])) {
            $query->where('email', 'like', "%".$input['email']."%");
        }
        if(!empty($input['type'])) {
            $query->where('type', '=', $input['type']);
        }
        if(!empty($input['status_id'])) {
            $query->where('status_id', '=', $input['status_id']);
        }
        
        $query->orderBy('created_at','DESC');

        if(!empty($input['limit'])){
            return $query->paginate($input['limit']);
        }else{
            return $query->get();
        }

    }


    public function status(){
        return $this->belongsTo(status::class , 'status_id', 'id');
    }

}
