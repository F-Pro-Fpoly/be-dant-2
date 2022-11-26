<?php
namespace App\Http\Transformer\banner;


use App\Models\banner;
use League\Fractal\TransformerAbstract;

class BannerTransformer extends TransformerAbstract
{
    public function transform(banner $banner)
    {
        return [
            'id'   => $banner->id,                   
            'name' => $banner->name,          
            'status' => $banner->status,
            'image' => $banner->file->url,
            'description' => $banner->description,
            'button' => $banner->button,
            'link' => $banner->link,
            'updated_at' => date_format($banner->updated_at, "d/m/Y"),
        ];
    }
}