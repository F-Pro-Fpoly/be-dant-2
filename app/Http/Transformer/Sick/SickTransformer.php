<?php
namespace App\Http\Transformer\Sick;

use App\Models\Sick;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class SickTransformer extends TransformerAbstract
{
    public function transform(Sick $sick)
    {
        return [
            'id'   => $sick->id,
            'code' => $sick->code,
            'name' => $sick->name,
            'slug' => $sick->slug,
        ];
    }
}