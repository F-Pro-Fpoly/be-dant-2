<?php
namespace App\Http\Transformer\Schedule;

use App\Models\Schedule;
use App\Models\TimeslotDetail;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class ScheduleDetailTransformer extends TransformerAbstract
{
    public function transform(TimeslotDetail $timeslotDetail)
    {   
        // dd($timeslotDetail->status);
        return [
            "id" => $timeslotDetail->id,
            "time_start" => $timeslotDetail->timeslot->time_start,
            'time_end' =>$timeslotDetail->timeslot->time_end,
            'status' => $timeslotDetail->status->name ?? null
        ];
    }
}