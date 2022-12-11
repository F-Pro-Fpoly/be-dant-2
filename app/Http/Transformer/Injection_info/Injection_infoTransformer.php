<?php
namespace App\Http\Transformer\Injection_info;

use App\Models\Injection_info;
use League\Fractal\TransformerAbstract;

class Injection_infoTransformer extends TransformerAbstract {
    public function transform(Injection_info $injection_info)
    {
        return [
            "type" => $injection_info->type,
            "time_apointment" => $injection_info->time_apointment->format('d/m/Y'),
            'booking_id' => $injection_info->time
        ];
    }
}