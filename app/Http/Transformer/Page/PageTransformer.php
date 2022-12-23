<?php
namespace App\Http\Transformer\Page;

use App\Models\Page;
use App\Models\Specialist;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class PageTransformer extends TransformerAbstract
{
    public function transform(Page $page)
    {
        return [
            'id'   => $page->id,         
            'name' => $page->name,
            'slug' => $page->slug,
            'font' => $page->font,
            'status' => $page->status,
            'sort' => $page->sort,
            'created_at' => date_format($page->created_at, "Y/m/d H:i:s"),
        ];
    }
}