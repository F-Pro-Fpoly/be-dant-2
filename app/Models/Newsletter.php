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

    public function searchNewsletter(array $input){
        $query = $this->model();

        if(!empty($input['email'])) {
            $query->where('email', 'like', "%".$input['email']."%");
        }

        // $query->orderBy('created_at ','DESC');

        if(!empty($input['limit'])){
            return $query->limit($input['limit'])->paginate();
        }else{
            return $query->get();
        }
    }
}
