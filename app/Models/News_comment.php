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
        // $dataInput = [];
        // if(!empty($input['news_id'])){
        //     $dataInput[] = [
        //         'news_id' , "=", $input['news_id']
        //     ];
        // };

        // if(!empty($input['status'])){
        //     $dataInput[] = [
        //         'status' , "like", "%".$input['status']."%"
        //     ];
        // };

        // if(!empty($input['id'])) {
        //     $query->where('id', 'like', "%".$input['id']."%")
        //     ->where('status', '=', '1');
        // }
        // if(!empty($input['user_id'])) {
        //     $query->where('user_id', 'like', "%".$input['user_id']."%")
        //     ->where('status', '=', '1');
        // }
        // if(!empty($input['news_id'])) {
        //     $query->where('news_id', 'like', "%".$input['news_id']."%")
        //     ->where('status', '=', '1');
        // }
        // if(!empty($input['content'])) {
        //     $query->where('content', '=', $input['content'])
        //     ->where('status', '=', '1');
        // }
        // if(!empty($input['status'])) {
        //     $query->where('status', '=', $input['status'])
        //     ->where('status', '=', '1');
        // }

        // $data = $this->search($dataInput, [], 5);
        $query = $this->model();
        if(!empty($input['news_id'])){
            $query->where('news_id', $input['news_id']);
        }

        if(!empty($input['status'])){
            $query->where('status', 'like', "%".$input['status']."%");
        }

        $query->orderBy('created_at', 'desc');
       
        return  $query->paginate(5);
    }


    public function news(){
        return $this->belongsTo(News::class , 'news_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class , 'user_id', 'id');
    }

}
