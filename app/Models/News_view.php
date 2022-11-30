<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News_view extends BaseModel
{
    use HasFactory;
    protected $table = 'news_views';
    protected $fillable = [
        'number', 
        'news_id',
        'created_at',
        'updated_at',
    ];

    public function searchNews($input = []){
        $dataInput =[];
        if(!empty($input['id'])){
            $dataInput[] = [
                'id' , "=" ,$input['id']
            ];
        }
        if(!empty($input['number'])){
            $dataInput[] = [
                'number' , "=" ,$input['number']
            ];
        }
        if(!empty($input['news_id'])){
            $dataInput[] = [
                'news_id' , "=" ,$input['news_id']
            ];
        }
        if(!empty($input['created_at'])){
            $dataInput[] = [
                'created_at' , "=",$input['created_at']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

 
    public function news(){
        return $this->belongsTo(News::class);
    }
}
