<?php
namespace App\Http\Transformer\Ward;

use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use League\Fractal\TransformerAbstract;

class WardTransformer extends TransformerAbstract
{
    public function transform(Ward $ward)
    {
        return [
            'id' => $ward->id,
            'code' => $ward->code,
            'name' => $ward->name,
            'full_name' => $ward->full_name,
            'district_code' => $ward->district_code,
            'district_id' => $ward->district_id,
            'district_name' => $ward->district->name ?? null
        ];
    }
}