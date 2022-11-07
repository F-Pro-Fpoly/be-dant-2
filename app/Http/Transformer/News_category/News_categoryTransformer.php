<?php
namespace App\Http\Transformer\News_category;

use App\Models\News_category;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class News_categoryTransformer extends TransformerAbstract
{
    public function transform(News_category $news_category)
    {
        return [
            'id'   => $news_category->id,
            'code' => $news_category->code,
            'slug' => $news_category->slug,
            'status' => $news_category->status,
            'name' => $news_category->name,
        ];
    }
}