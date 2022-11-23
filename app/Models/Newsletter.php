<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends BaseModel
{
    use HasFactory;
    protected $table = 'newsletters';
    protected $fillable = [
        'email',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function searchNewsletter($input = []){
        $dataInput =[];
        if(!empty($input['email'])){
            $dataInput[] = [
                'email' , "=" ,$input['email']
            ];
        }
        
        $data = $this->search($dataInput, [], 5);
        return $data;
    }
}
