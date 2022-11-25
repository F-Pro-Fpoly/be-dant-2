<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends BaseModel
{
    use HasFactory;
    protected $table = 'news';
    protected $fillable = [
        'code',
        'slug', 
        'featured',
        'status',
        'category_id',
        'name',
        'file',
        'content',
        'view',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function searchNews($input = []){
        $dataInput =[];
        if(!empty($input['code'])){
            $dataInput[] = [
                'code' , "=" ,$input['code']
            ];
        }
        if(!empty($input['featured'])){
            $dataInput[] = [
                'featured' , "=" ,$input['featured']
            ];
        }
        if(!empty($input['status'])){
            $dataInput[] = [
                'status' , "=" ,$input['status']
            ];
        }
        if(!empty($input['category_id'])){
            $dataInput[] = [
                'category_id' , "=",$input['category_id']
            ];
        }
        if(!empty($input['name'])){
            $dataInput[] = [
                'name' , "=",$input['name']
            ];
        }
        $data = $this->search($dataInput, [], 5);
        return $data;
    }

 
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function news_category(){
        return $this->belongsTo(News_category::class, 'category_id', 'id');
    }
}
