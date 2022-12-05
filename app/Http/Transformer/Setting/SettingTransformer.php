<?php
namespace App\Http\Transformer\setting;


use App\Models\setting;
use App\Models\Specialist;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class SettingTransformer extends TransformerAbstract
{
    public function transform(setting $setting)
    {
        return [
            'id'   => $setting->id,         
            'code' => $setting->code,          
            'status' => $setting->status,
            'description' => $setting->description,
            'updated_at' => date_format($setting->updated_at, "d/m/Y"),
        ];
    }
}