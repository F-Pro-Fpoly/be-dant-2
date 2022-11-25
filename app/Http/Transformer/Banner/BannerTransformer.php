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
            'code' => $banner->code,          
            'name' => $banner->name,          
            'status' => $banner->status,
            'image' => $banner->file->url,
            'description' => $banner->description,
            'updated_at' => date_format($banner->updated_at, "d/m/Y"),
        ];
    }
}