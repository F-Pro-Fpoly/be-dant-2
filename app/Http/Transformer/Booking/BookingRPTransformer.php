<?php
namespace App\Http\Transformer\Booking;

use App\Models\Booking;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class BookingROTransformer extends TransformerAbstract
{
    public function transform(Booking $booking)
    {
              
        return [
            'code' => $booking->code,
            'department' => $booking->department->name,
            'schedule' => $booking->schedule->name,
            'user' => $booking->user->name,
            'doctor' => $booking->user->name,
            'status' => $booking->status->name,
            'specialists_name'   => $booking->specialists_name,
            'specialist' => $booking->specialist->name,
            'vaccine' => $booking->vaccine->name,
            'payment_method' => $booking->payment_method,
            'address' => $booking->address,
            'city' => $booking->city->name,
            'customer_name' => $booking->customer_name,
            'type' => $booking->type,
            'phone' => $booking->email,
            

        ];
    }
}