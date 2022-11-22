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
      
      
        return [
            'id'   => $booking->id,
            'code' => $booking->code,
            'department_id' => $booking->department_id,
            'department_name' => $booking->department->name ?? null,
            'schedule_id' => $booking->schedule_id,
            'schedule_name' => $booking->schedule->description ?? null,       
            'user_id' => $booking->user_id,
            'customer_name' => $booking->customer_name,
            'payment_method' => $booking->payment_method,    
            'status_id' => $booking->status_id,
            'status_code' => $booking->status_code,
            'address' => $booking->address,
            'city_code' => $booking->city_code,
            'type' => $booking->type,
            'phone' => $booking->phone,
            'birthday' => $booking->birthday,
            'district_code' => $booking->district_code,
            'price' => $booking->price,
            'ward_code' => $booking->ward_code,
            'date' => $booking->schedule->date,
            'time_start' =>$booking->schedule->timeslot->time_start,
            'time_end' =>$booking->schedule->timeslot->time_end,
        ];
    }
}