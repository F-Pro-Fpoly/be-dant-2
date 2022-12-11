<?php
namespace App\Http\Transformer\Booking;

use App\Models\Booking;
use App\Models\Injection_info;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class BookingVaccineTransformer extends TransformerAbstract
{
    public function transform(Booking $booking)
    {
        $data = [
            'id'=>$booking->id,
            'code' => $booking->code,
            'doctor_id' => $booking->doctor_id,
            'doctor_name' => $booking->doctor->name ?? null,
            'vaccine_code' => $booking->vaccine_code,
            'vaccine_name' => $booking->vaccine->name ?? null, 
            'description' => $booking->description,
            'injection_info' => []
        ];
        $injection_infos = $booking->Injection_info;

        foreach($injection_infos as $injection_info) {
            if($injection_info->status_code == 'NEWVACCINE') {
                break;
            }
            $new_injection_info = [
                'type' => $injection_info-> type,
                'time_apointment'=> date('d-m-Y', strtotime($injection_info->time_apointment)),
                'type_name' => $injection_info->type_name,
                'status_code' => $injection_info->status_code,
                'file_id' => $injection_info->file_id,
                'file_url' => $injection_info->file->url ?? null,
                'description' => $injection_info->description
            ];

            array_push($data['injection_info'], $new_injection_info);
        }

        return $data;
    }
}