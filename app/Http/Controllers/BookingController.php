<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Booking\BookingTransformer;
use App\Http\Validators\Booking\InsertBookingValidate;
use App\Http\Validators\Booking\UpdateBookingValidate;
use App\Models\Booking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookingController extends BaseController
{
   public function addBooking(Request $request)
    {
        $input = $request->all();
        (new InsertBookingValidate($input));

        try {

           Booking::create([
                "code" => $input['code'], 
                "department_id" => $input['department_id'], 
                "schedule_id" => $input['schedule_id'],
                "timeSlot_id" => $input['timeSlot_id'],
                "user_id" => auth()->user()->id,
                "created_by" => auth()->user()->id
           ]);

           return response()->json([
                'status' => 200,
                'message' => "Đặt lịch thành công"
           ], 200);
        } catch (\Throwable $th) {
           return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() 
                ],500
                );
        }

    }
    public function listBooking(Request $request){
        $input = $request->all();
        $booking = new Booking();
        $data = $booking->searchBooking($input);
        return $this->response->paginator($data, new BookingTransformer);
    }

    public function updateBooking(Request $request, $id){
       $input = $request->all();
       (new UpdateBookingValidate($input));

        try {
            $data = Booking::find($id);
            if($data){
                $data->update([
                    'code' => $input['code'] ?? $data->code,
                    // "department_id" => $input['department_id'] ??  $data->department_id, 
                    // 'schedule_id' => $input['schedule_id'] ?? $data->schedule_id,
                    // 'timeSlot_id' => $input['timeSlot_id'] ?? $data->timeSlot_id,
                    'status_id' => $input['status_id'] ?? $data->status_id,
                    'updated_by' => auth()->user()->id
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật đặt lịch thành công"
               ], 200);
            }
            else{
                return response()->json([
                    'status'  => 400,
                    'message' => 'Không tìm thấy lịch đặt',
                ],400);
            }
        } 
        catch (Exception $th){
            throw new HttpException(500, $th->getMessage());
        }
    }

    // delete
    public function deleteBooking($id){
        try {
            $data = Booking::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa bệnh thành công"
            ], 200);
        }
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
