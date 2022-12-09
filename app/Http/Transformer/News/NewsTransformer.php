<?php
namespace App\Http\Transformer\News;

use App\Models\News;

use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class NewsTransformer extends TransformerAbstract
{
    public function transform(News $news)
    {
        return [
            'id'   => $news->id,
            'code' => $news->code,
            'slug' => $news->slug,
            'featured' => $news->featured,
            'status' => $news->status,
            'category_id' => $news->category_id,
            'name' => $news->name,
            'file' => $news->file,
            'content' => $news->content,
            'views' => $news->view,
            'created_at' => $news->created_at->format('d-m-Y'),
            'category_name' => $news->news_category->name ?? null,
        ];
    }
}