<?php
namespace App\Http\Transformer\Booking;

use App\Models\Booking;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class BookingDPTransformer extends TransformerAbstract
{
    public function transform(Booking $booking)
    {
              
        return [
            'specialists_name'   => $booking->specialists_name,
            'price' => $booking->price,
            'price_format' => Number_format($booking->price)." VNĐ",
        ];
    }
}