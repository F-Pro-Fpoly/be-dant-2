<?php
namespace App\Http\Transformer\Specialist;


use App\Models\Specialist;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class SpecialistTransformer extends TransformerAbstract
{
    public function transform(Specialist $spct)
    {
        return [
            'id'   => $spct->id,
            'code' => $spct->code,
            'name' => $spct->name,
            'slug' => $spct->slug,
            'is_feature' => $spct->is_feature,
            'status' => $spct->status,
            'thumbnail_id' => $spct->thumbnail_id ?? null,
            'thumbnail_name' => $spct->file->url ?? null,
            'description' => $spct->description,
            'short_description' => $spct->short_description
        ];
    }
}