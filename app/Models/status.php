<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'deleted_at',
    ];

    public function booking(){
        return $this->hasOne(Booking::class, 'status_id');
    }

    public function contact(){
        return $this->hasOne(contact::class, 'status_id');
    }

    public function searchListStatus(array $input) {
      
        $query = $this->model();

        $query->where('id',1);
        $query->orWhere('id',2);
        $query->orWhere('id',3);
        $query->orWhere('id',4);
        $query->orderBy('created_at','DESC');
        if(!empty($input['limit'])){
            return $query->limit($input['limit'])->paginate();
        }else{
            return $query->get();
        }
    }
}
