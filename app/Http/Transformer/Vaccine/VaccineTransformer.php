<?php
namespace App\Http\Transformer\Vaccine;

use App\Models\Vaccine;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class VaccineTransformer extends TransformerAbstract
{
    public function transform(Vaccine $vaccine)
    {
        return [
            'id'   => $vaccine->id,
            'code' => $vaccine->code,
            'name' => $vaccine->name,
            'slug' => $vaccine->slug,
            'price' => $vaccine->price,
            'description' => $vaccine->description,
            'sick_id' => $vaccine->sick_id,
            'national_id' => $vaccine->national_id,
            'is_active' => $vaccine->is_active,
        ];
    }
}