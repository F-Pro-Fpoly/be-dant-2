<?php
namespace App\Http\Transformer\News_comment;

use App\Models\News_comment;
use App\Models\News;

use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class News_commentTransformer extends TransformerAbstract
{
    public function transform(News_comment $news_comment)
    {
        return [
            'id'   => $news_comment->id,
            'news_id' => $news_comment->news_id,
            'user_id' => $news_comment->user_id,
            'user_name' => $news_comment->user->name,
            'user_avatar' => $news_comment->user->avatar,
            'content' => $news_comment->content,
            'status' => $news_comment->status,
            'created_at' => $news_comment->created_at->format('d-m-Y H:i:s'),
        ];
    }
}