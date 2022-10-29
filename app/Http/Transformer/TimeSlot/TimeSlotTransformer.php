<?php
namespace App\Http\Transformer\TimeSlot;


use App\Models\Specialist;
use App\Models\Timeslot;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class TimeSlotTransformer extends TransformerAbstract
{
    public function transform(Timeslot $spct)
    {
        return [
            'id'   => $spct->id,
            'time_start' => $spct->time_start,
            'time_end' => $spct->time_end,
        ];
    }
}