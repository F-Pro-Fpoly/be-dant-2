<?php
namespace App\Http\Controllers;

use App\Http\Validators\Injection_info\CreateInjectionInfoValidate;
use App\Models\Booking;
use App\Models\File;
use App\Models\Injection_info;
use App\Supports\TM_Error;
use Illuminate\Http\Request;

class Injection_infoController extends BaseController
{
    public function update_injection_info (Request $request) 
    {
        $input = $request->all();

        if(empty($input['booking_id'])){
            return $this->response->error("Không tồn tại booking này", 400);
        }

        try {
            if(empty($input['id'])) {
                return $this->response->error("Vui lòng nhập id", 400);           
            }
            if(!empty($input['file_new'])) {
                $file = File::create([
                    'url' => $input['file_new'],
                    'created_by' => auth()->user()->id ?? null
                ]);

                $input['file_id'] = $file->id;
            }
            $injection_info = Injection_info::findOrFail($input['id']);
            $injection_info->update_injection_info($input);
            return response()->json([
                'message' => 'Cập nhập thành cônng'
            ], 200);
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);

            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }

    public function create_injection_info (Request $request) 
    {
        $input = $request->all();

        (new CreateInjectionInfoValidate($input));

        try {
            if(!empty($input['booking_id'])){
                $booking_code = Booking::where('id', $input['booking_id'])->value('code');
            }

            $input_injection_info = [
                'type' => $input['type'],
                'time_apointment' => $input['time_apointment'],
                'type_name' => $input['type_name'],
                'status_code' => $input['status_code'],
                'booking_id' => $input['booking_id'],
                'booking_code' => $booking_code ?? null
            ];

            Injection_info::create($input_injection_info);

            return response()->json([
                'message' => 'Thêm lịch thành công'
            ],200);
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);

            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }
}