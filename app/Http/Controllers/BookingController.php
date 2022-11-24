<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Booking\BookingTransformer;
use App\Http\Transformer\Booking\StatusTransformer;
use App\Http\Validators\Booking\CreateBookingNoAuthValidate;
use App\Http\Validators\Booking\CreateBookingValidate;
use App\Http\Validators\Booking\InsertBookingValidate;
use App\Http\Validators\Booking\UpdateBookingValidate;
use App\Models\Booking;
use App\Models\File;
use App\Models\Schedule;
use App\Models\status;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

    public function listBookingDoctor(Request $request){
        $input = $request->all();
        $booking = new Booking();
        $data = $booking->searchBookingDoctor($input);
        return $this->response->collection($data, new BookingTransformer);
    }

    public function statusBooking(Request $request){
        $input = $request->all();
        $listStatus = new status();
        $data = $listStatus->searchListStatus($input);
        return $this->response->collection($data, new StatusTransformer);
    }

    public function detailBooking($id){
        try {
            $booking = Booking::findOrFail($id);
            return $this->response->item($booking, new BookingTransformer());
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }    
    }

    public function listMyBooking(Request $request, $id){
       
        $input = $request->all();
        $booking = new Booking();
        $data = $booking->searchMyBooking($input,$id);
        return $this->response->collection($data, new BookingTransformer);
    }
    

    public function updateBookingDoctor(Request $request, $id)
    {
        $input = $request->all();
     
        try {    
            $data = Booking::find($id);
        
            if(!empty($input['file'])){
                $file = $request->file('file')->store('files','public');          
                $file = File::create([            
                    'alt' => null,
                    'url' => $file ?? null
                ]);

                $file_id = $file->id;
            }

            $data->update([
                "status_id"            => Arr::get($input, 'statusBooking',$data->status_id),
                "infoAfterExamination" => Arr::get($input, 'info',  $data->infoAfterExamination),
                "id_file"              => $file_id ?? $data->id_file,
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Cập nhật lịch khám thành công"
           ], 200);
            // dd($request->file('file'));

        } catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
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

    // Client
    public function create_booking_client(Request $request) {
        $input = $request->all();
        (new CreateBookingValidate($input));
        $date = date('YmdHis', time());
        try {
            $user_id = auth()->user()->id ?? null;
            $input['code'] = "BOOKING{$date}".random_int(10, 99);
            $doctor_id = $input['doctor_id'];
            $user = User::findOrFail($doctor_id);
            $department_id = $user->department_id ?? null;
            $input['department_id'] = $department_id;
            // get specialist_id
            $input['specialist_id'] = $user->specailist_id ?? null;
            if(!empty($user_id)){
                $input['user_id'] = $user_id;
                $input = $this->handle_data_booking_auth($input);
            }else{
                $input = $this->handle_data_booking_noAuth($input);
            }

            // Cập nhập status schedule
            $inputSchule = [
                'status_id' => 7,
                'status_code' => 'BOOKED'
            ];
            $schedule = Schedule::findOrFail($input['schedule_id']);
            $schedule->update_schedule($inputSchule);
            $booking = new Booking();
            $booking->create_booking($input);


            return response()->json([
                'message' => "Thêm booking thành công"
            ],200);
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    private function handle_data_booking_auth ($input) {
        $input['status_id'] = 1;
        $input['status_code'] = 'NEW';
        $input['type'] = 'LOGIN';
        $input['created_by'] = $input['user_id'];
        return $input;
    }

    private function handle_data_booking_noAuth($input) {
        (new CreateBookingNoAuthValidate($input));
        $input['status_id'] = 1;
        $input['status_code'] = 'NEW';
        $input['type'] = 'NOLOGIN';
        return $input;
    }
}
