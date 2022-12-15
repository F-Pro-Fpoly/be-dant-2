<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Booking\BookingTransformer;
use App\Http\Transformer\Booking\BookingVaccineTransformer;
use App\Http\Transformer\Booking\StatusTransformer;
use App\Http\Validators\Booking\CreateBookingNoAuthValidate;
use App\Http\Validators\Booking\CreateBookingValidate;
use App\Http\Validators\Booking\InsertBookingValidate;
use App\Http\Validators\Booking\UpdateBookingValidate;
use App\Models\Booking;
use App\Models\File;
use App\Models\Injection_info;
use App\Models\Schedule;
use App\Models\Specialist;
use App\Models\status;
use App\Models\User;
use App\Supports\TM_Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

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
        if(empty($input['is_vaccine'])) {
            $data = $booking->searchBookingDoctor($input);
        }else{
            $data = $booking->searchBookingDoctor_v2($input);
        }
        return $this->response->paginator($data, new BookingTransformer);
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
       try {
            $input = $request->all();
            $booking = new Booking();
            $data = $booking->searchMyBooking($input,$id);
            return $this->response->collection($data, new BookingTransformer);
       } catch (\Exception $th) {
            $ex_handle = new TM_Error($th);
            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
       }
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

            $state_code = status::where('id', $input['statusBooking'])->first();

            $data->update([
                "status_id"            => Arr::get($input, 'statusBooking',$data->status_id),
                "status_code"          => $state_code->code,
                "infoAfterExamination" => Arr::get($input, 'info',  $data->infoAfterExamination),
                "reasonCancel"         =>  Arr::get($input, 'reasonCancel',  $data->reasonCancel),
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


    public function cancelBooking(Request $request, $id)
    {
        $input = $request->all();
        try{
            $data = Booking::find($id);
            $schedule =  $data->schedule_id;
            $data->update([
                'status_id' => $input['status_id'],
                'schedule_id' => null   
            ]);
            $returnStatus = Schedule::find($schedule);
            $returnStatus->update([
                'status_code' => "STILLEMPTY",
                'status_id' => 6,
                 
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Hủy lịch thành công"
           ], 200);
        }
        catch (Exception $th){
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
           
            // bắn  thông báo firebase

            $fields  = [      
                'id' =>  mt_rand(100000,999999),
                'notification' => "Có một thông báo mới",       
                'status' =>       1
            ];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL =>  env('FIREBASE_DBR_URL', ''),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>json_encode($fields),
                CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
                ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);       

            
            $e = $booking->email;
            if(empty($e)){
                $data = DB::table('bookings')
                ->select('users.*',"bookings.code", 'bookings.created_at as ld','specialists.name as ck','schedules.date as nk', 'timeslots.time_start as bd', 'timeslots.time_end as kt')
                ->join('users','users.id', "=", 'bookings.user_id')
                ->join('specialists', 'specialists.id', "=", "bookings.specialist_id")
                ->join('schedules', 'schedules.id', "=", "bookings.schedule_id")
                ->join('timeslots', 'timeslots.id', "=", "schedules.timeslot_id")

                ->where("bookings.id", $booking->id)
                ->first();
                $e = $data->email ?? null; 
            }
            if(!empty($data)){
                Mail::send('email.BookingBooked',compact('booking','data'), function ($email) use ($e) {
                    $email->from('phuly4795@gmail.com','Fpro Hopital');
                    $email->subject('Fpro Hopital - Cảm ơn bạn đã đăng ký dịch vụ của chúng tôi');
                    $email->to($e, 'Quý khách');
                });
            }
            return response()->json([
                'message' => "Thêm booking thành công"
            ],200);
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function create_booking_vaccine(Request $request) {
        $input = $request->all();

        $date = date('YmdHis', time());

        try {
            $user_id = auth()->user()->id ?? null;
            $input['code'] = "BOOKING{$date}".random_int(10, 99);
            // vaccine_code, user_id, 

            if($user_id) {
                $input['user_id'] = $user_id;
            }
            $input['status_id'] = 1;
            $input['status_code'] = "NEW";
            $input['is_vaccine'] = 1;
            $input['type'] = 'LOGIN';

            $specialist_vaccine = Specialist::where('code', 'vaccine')->first();

            $input_booking = [
                'code' => $input['code'],
                'status_id' => 1,
                'status_code' => 'NEW',
                'vaccine_code' => $input['vaccine_code'] ?? null,
                'is_vaccine' => 1,
                'type' => 'LOGIN',
                'user_id' => $user_id,
                'description' => $input['description'] ?? null,
                'specialist_id' => $specialist_vaccine->id ?? null
            ];

            $booking =  Booking::create($input_booking);
            if(!empty($input['is_vaccine'])){
                $input_injection = [
                    'type' => 'screening_test',
                    'time_apointment' => $input['date'] ?? null,
                    'status_code' => 'NEWVACCINE',
                    'booking_id' => $booking->id ?? null,
                    'booking_code' => $booking->code ?? null,
                    'created_by' => $user_id,
                    'type_name' => 'Khám sàn lọc'
                ];

                Injection_info::create($input_injection);
            }

            return response()->json([
                'message' => 'Đặt lịch tiêm thành công'
            ], 200);
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);
            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
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


    public function get_booking_vaccine($user_id, Request $request) {
        $input = $request->all();

        try {
            $is_booking_vaccine = Booking::where('user_id', $user_id)->where('is_vaccine', 1)->exists();
            if(!$is_booking_vaccine) {
                return $this->response->error("Bệnh nhân này chưa tiêm mũi vaccine nào", 400);
            }
            $booking = Booking::where('user_id', $user_id)->where('is_vaccine', 1)->get();


            return $this->response->collection($booking, new BookingVaccineTransformer());
        } catch (\Exception $ex) {
            DB::rollBack();
            $ex_handle = new TM_Error($ex);
            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }
}
