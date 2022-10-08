<?php
namespace App\Http\Transformer\Booking;

use App\Models\Booking;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class BookingTransformer extends TransformerAbstract
{
    public function transform(Booking $booking)
    {
        // dd($booking->timeslot);
        return [
            'id'   => $booking->id,
            'code' => $booking->code,
            'department_name' => $booking->department->name,
            'schedule_name' => $booking->schedule->description,
            'date' => $booking->schedule->date,
            'timeSlot_start' => $booking->timeslot->time_start,
            'timeSlot_end' => $booking->timeslot->time_end,
            'user_name' => $booking->user->name,
            'status' => $booking->status->name,
        ];
    }
}