<?php
namespace App\Http\Transformer\Booking;

use App\Models\status;

use League\Fractal\TransformerAbstract;

class StatusTransformer extends TransformerAbstract
{
    public function transform(status $status)
    {
        
        return [
            'id'   => $status->id,
            'code' => $status->code,
            'name' => $status->name, 
        ];
        
    }
}