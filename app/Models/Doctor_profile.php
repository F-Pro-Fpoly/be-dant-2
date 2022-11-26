<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor_profile extends BaseModel
{
    use HasFactory;
    protected $table = 'doctor_profiles';
    protected $fillable = [
        'id_user',
        'namelink',
        'link',
        'context',
        'level',
        'introduce',
        'experience',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function searchDoctor_profile($input=[])
    {
        $dataInput = [];
        if(!empty($input['id_user'])){
            $dataInput[] = [
                'id_user'  , "=", $input['id_user']
            ];
        }
        if(!empty($input['link'])){
            $dataInput[] = [
                'link' , "=", $input['link']
            ];
        }
        if(!empty($input['context'])){
            $dataInput[] = [
                'context' , "like", "%".$input['context']."%"
            ];
        }
        if(!empty($input['level'])){
            $dataInput[] = [
                'level' , "like", "%".$input['level']."%"
            ];
        }
        if(!empty($input['introduce'])){
            $dataInput[] = [
                'introduce' , "like", "%".$input['introduce']."%"
            ];
        }
        if(!empty($input['experience'])){
            $dataInput[] = [
                'experience' , "like", "%".$input['experience']."%"
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    
}
