<?php
namespace App\Http\Transformer\District;

use App\Models\City;
use App\Models\District;
use League\Fractal\TransformerAbstract;

class DistrictTransformer extends TransformerAbstract
{
    public function transform(District $district)
    {
        return [
            'id' => $district->id,
            'code' => $district->code,
            'name' => $district->name,
            'full_name' => $district->full_name,
            'city_code' => $district->city_code,
            'city_id' => $district->city_id,
            'city_name' => $district->city->name ?? null
        ];
    }
}