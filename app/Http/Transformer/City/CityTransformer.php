<?php
namespace App\Http\Transformer\City;

use App\Models\City;
use League\Fractal\TransformerAbstract;

class CityTransformer extends TransformerAbstract
{
    public function transform(City $city)
    {
        return [
            'id' => $city->id,
            'code' => $city->code,
            'name' => $city->name,
            'full_name' => $city->full_name
        ];
    }
}