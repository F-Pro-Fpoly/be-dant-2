<?php
namespace App\Http\Transformer\Schedule;

use App\Models\Schedule;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class ScheduleTransformer extends TransformerAbstract
{
    public function transform(Schedule $schedule)
    {
        return [
            "id" => $schedule->id,
            'code'=> $schedule->code,
            'date' => $schedule->date,
            'description' => $schedule->description,
            'timeslot_id' => $schedule->timeslot_id,
            'time_start' => $schedule->timeslot->time_start,
            'time_end' => $schedule->timeslot->time_end,
            'status_code' => $schedule->status_code,
            'status_name' => $schedule->status->name ??null
        ];
    }
}