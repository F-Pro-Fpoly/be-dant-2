<?php

namespace App\Http\Controllers;

use App\Http\Validators\Booking\InsertBookingValidate;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    // public function listSick(Request $request)
    // {
    //     $input = $request->all();
    //     $sick = new sick();
    //     $data = $sick->searchSick($input);
    //     return $this->response->paginator($data, new SickTransformer);

    // }

    // public function updateSick(Request $request, $id)
    // {
    //    $input = $request->all();
    //    (new InsertSickValidate($input));

    //   try {
    //         $data = Sick::find($id);
    //         $data->update([
    //             'code' => $input['code'],
    //             'name' => $input['name'],
    //             'slug' => Str::slug($input['name']),
    //             'updated_by' => auth()->user()->id
    //         ]);
    //         return response()->json([
    //             'status' => 200,
    //             'message' => "Cập nhật bệnh thành công"
    //        ], 200);
    //   } catch (\Throwable $th) {
    //     return response()->json(
    //         [
    //             'status' => 500,
    //             'message' => $th->getMessage() 
    //         ],500
    //         );
    //   }
       
    // }

    // public function deleteSick($id)
    // {
    //    try {
    //         $data = Sick::find($id);
    //         $data->deleted =1;
    //         $data->deleted_by = auth()->user()->id;
    //         $data->save();
    //         $data->delete();
    //         return response()->json([
    //             'status' => 200,
    //             'message' => "Xóa bệnh thành công"
    //     ], 200);
    //    } catch (\Throwable $th) {
    //     return response()->json(
    //         [
    //             'status' => 500,
    //             'message' => $th->getMessage() 
    //         ],500
    //         );
    //    }
    // }
}
