<?php

namespace App\Http\Controllers;

use App\Http\Validators\Booking\CreateBookingNoAuthValidate;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentController extends Controller
{
    public function PaymentVNPAY(Request $request)
    {
        $input = $request->all();
      
        $date = date('YmdHis', time());
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $id_booking = "BOOKING{$date}".random_int(10, 99);
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:3000/cam-on-da-dat-lich";
        $vnp_TmnCode = "LYIUHWCF";//Mã website tại VNPAY 
        $vnp_HashSecret = "MRNHXQYFSGCDEDNEKKVNEYYUIQYPCDJG"; //Chuỗi bí mật

        $vnp_TxnRef =  $id_booking; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán đặt lịch";
        $vnp_OrderType = "billpayment";
        $vnp_Amount =   $input['price'] * 100;
        $vnp_Locale =   "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
  
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {    
              
              
                $user_id = auth()->user()->id ?? null;
                $input['code'] = $id_booking;
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

                die();
                    
            } else {
                    $user_id = auth()->user()->id ?? null;
                  
                    $input['code'] = $id_booking;
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
                   
                echo json_encode($returnData);
            }
            // vui lòng tham khảo thêm tại code demo
    }

    private function handle_data_booking_auth ($input) {
        $input['status_id'] = 1;
        $input['status_code'] = 'NEW';
        $input['type'] = 'LOGIN';
        $input['created_by'] = $input['user_id'];
        return $input;
    }

    private function handle_data_booking_noAuth($input) {
        // (new CreateBookingNoAuthValidate($input));
        $input['status_id'] = 1;
        $input['status_code'] = 'NEW';
        $input['type'] = 'NOLOGIN';
        return $input;
    }

}
