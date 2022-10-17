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
        ];
    }
}