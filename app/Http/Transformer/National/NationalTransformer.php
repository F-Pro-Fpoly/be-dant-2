<?php
namespace App\Http\Transformer\National;

use App\Models\National;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class NationalTransformer extends TransformerAbstract
{
    public function transform(National $national)
    {
        return [
            "id" => $national->id,
            'code'=> $national->code,
            'name' => $national->name,
            'slug' => $national->slug,
        ];
    }
}