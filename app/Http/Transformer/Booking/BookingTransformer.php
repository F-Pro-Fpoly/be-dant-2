<?php
namespace App\Http\Transformer\Booking;

use App\Models\Booking;
use App\Models\Injection_info;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class BookingTransformer extends TransformerAbstract
{
    public function transform(Booking $booking)
    {

        $time  = $booking->Injection_info;
    
        foreach($time as $item) {
           
            $times       = $item->time_apointment;
            $type        = $item->type;
            $status_code = $item->status_code;
            $type_name = $item->type_name;
            $description = $item->description;
        }

        

        if($booking->type == "NOLOGIN"){
              $data =  [
                'id'   => $booking->id,
                'code' => $booking->code,
                'department_id' => $booking->department_id,
                'department_name' => $booking->department->name ?? null,
                'schedule_id' => $booking->schedule_id,
                'schedule_name' => $booking->schedule->description ?? null,       
                'user_id' => $booking->user_id,
                'customer_name' => $booking->customer_name,
                'payment_method' => $booking->payment_method,    
                'description' => $booking->description ?? null,    
                'reasonCancel' => $booking->reasonCancel ?? null,    
                'infoAfterExamination' => $booking->infoAfterExamination ?? null,    
                'id_file' => $booking->id_file ?? null,    
                'is_vaccine' => $booking->is_vaccine ?? null,    
                'vaccine_code' => $booking->vaccine_code ?? null,    
                'vaccine_name' => $booking->vaccine->name ?? null,    
                'file_name' => $booking->file->url ?? null,    
                'status_id' => $booking->status_id,
                'status_code' => $booking->status_code,
                'status_name' => $booking->status->name ?? null,
                'address' => $booking->address,
                'city_code' => $booking->city_code,
                'type' => $booking->type,
                'phone' => $booking->phone,
                'email' => $booking->email ?? null,
                'birthday' => $booking->birthday,
                'district_code' => $booking->district_code,
                'price' => $booking->price,
                'ward_code' => $booking->ward_code,
                'date' => $booking->schedule->date ?? null,
                'time_start' =>$booking->schedule->timeslot->time_start ?? null,
                'time_end' =>$booking->schedule->timeslot->time_end ?? null,
                'time_apointment' => $times ?? null,
                'type_Injection_info' => $type ?? null,
                'type_Injection_info_name' => $type_name ?? null,
                'status_code_Injection_info' => $status_code ?? null,
                'description_Injection_info' => $description ?? null,
                

            ];
        }
        else{
              
            $data =  [
                'id'   => $booking->id,
                'code' => $booking->code,
                'department_id' => $booking->department_id,
                'department_name' => $booking->department->name ?? null,
                'schedule_id' => $booking->schedule_id,
                'schedule_name' => $booking->schedule->description ?? null,       
                'user_id' => $booking->user_id,
                'customer_name' => $booking->user->name ?? null,
                'payment_method' => $booking->payment_method,    
                'description' => $booking->description ?? null,   
                'reasonCancel' => $booking->reasonCancel ?? null,   
                'infoAfterExamination' => $booking->infoAfterExamination ?? null,    
                'id_file' => $booking->id_file ?? null,    
                'file_name' => $booking->file->url ?? null,   
                'specialist_id' => $booking->specialist_id,
                'is_vaccine' => $booking->is_vaccine,
                'vaccine_code' => $booking->vaccine_code ?? null,    
                'vaccine_name' => $booking->vaccine->name ?? null,   
                'specialist_name' => $booking->specialist->name ?? null,
                'specialist_image' => $booking->specialist->file->url ?? null,
                'status_id' => $booking->status_id,
                'status_code' => $booking->status_code,
                'status_name' => $booking->status->name ?? null,
                'address' => $booking->user->address,
                'city_code' => $booking->user->city_code,
                'type' => $booking->type,
                'phone' => $booking->user->phone,
                'email' => $booking->user->email,
                'birthday' => $booking->user->birthday,
                'district_code' => $booking->user->district_code,
                'price' => $booking->price,
                'ward_code' => $booking->user->ward_code,
                'date' => $booking->schedule->date ?? null,
                'time_start' =>$booking->schedule->timeslot->time_start ?? null,
                'time_end' =>$booking->schedule->timeslot->time_end ?? null,
                'time_apointment' => $times ?? null,
                'type_Injection_info' => $type ?? null,
                'type_Injection_info_name' => $type_name ?? null,
                'status_code_Injection_info' => $status_code ?? null,
                'description_Injection_info' => $description ?? null
            ];
        }

        if($booking->is_vaccine == 1){
            $injection_info = Injection_info::model()->where('booking_id', $booking->id)->get();

            $injection_info_array = [];

            foreach($injection_info as $item) {
                $injection_info_array [] = [
                    'id' => $item->id,
                    'type' => $item->type,
                    'type_name' => $item->type_name,
                    'time_apointment' => $item->time_apointment,
                    'status_code' => $item->status_code,
                    'status_id' => $item->status->id ?? null,
                    'status_name' => $item->status->name ?? null,
                    'booking_id' => $item->booking_id,
                    'booking_code' => $item->booking_code,
                    'file_id' => $item->file_id ?? null,
                    'file_link' => $item->file->url ?? null,
                    'description' => $item->description ?? '',
                ];
            }

            $data_add = [
                'injection_info' => $injection_info_array
            ];
            $data = array_merge($data, $data_add);
        }

        return $data ;

    }
}