<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News_comment extends BaseModel
{
    protected $table = 'news_comments';
    protected $fillable = [
        'id',
        'user_id',
        'news_id',
        'content',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by',
    ];


    public function searchNews_comment($input = []){

        $query = $this->model();

        if(!empty($input['id'])) {
            $query->where('id', 'like', "%".$input['id']."%");
        }
        if(!empty($input['user_id'])) {
            $query->where('user_id', 'like', "%".$input['user_id']."%");
        }
        if(!empty($input['news_id'])) {
            $query->where('news_id', 'like', "%".$input['news_id']."%");
        }
        if(!empty($input['content'])) {
            $query->where('content', '=', $input['content']);
        }
        if(!empty($input['status'])) {
            $query->where('status', '=', $input['status']);
        }

        $data = $this->search($query, [], 5);
        return $data;

    }


    public function news(){
        return $this->belongsTo(News::class , 'news_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id', 'id');
    }

}
