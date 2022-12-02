<?php

namespace App\Http\Controllers;

use App\Exports\Turnover;
use App\Exports\BookingWithDay;
use App\Models\Booking;
use App\Models\Department;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ReportController extends Controller
{
   public function turnover(Request $request)
   {
      date_default_timezone_set('Asia/Ho_Chi_Minh');
      $input = $request->all();
    
      $date  = date('YmdHis', time());
        try {
           
            $data = Booking::select('specialists.name as specialists_name',Department::raw('SUM(departments.price) as price'))
            ->join('departments', 'departments.id', 'bookings.department_id')
            ->join('specialists', 'specialists.id', 'departments.specialist_id')
            ->groupBy('specialists.name')
            ->where('bookings.status_id', 4)
            ->get();            
            
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    return Excel::download(new Turnover($data), 'turnover_' . $date . '.xlsx');
   }
   public function BookingWithDay(Request $request)
   {
      date_default_timezone_set('Asia/Ho_Chi_Minh');
      $input = $request->all();
      $date  = date('d_m_Y', time());
      $time = date('H-i-s', time());
      $title ='Danh sách booking';
        try {
            $from = '';
            $to = '';
            if(!empty($input['from']) && !empty($input['to'])){
                $from = $input['from'];
                $to = $input['to'];
            }
            elseif(!empty($input['from']) && empty($input['to'])){
                $now = date('Y-m-d H:i:s');
                $from = $input['from'];
                $to = $now;
            }
            elseif(empty($input['from']) && !empty($input['to'])){
                $dataFrom = Booking::where('created_at', '<=', $to)->orderBy('created_at','asc')->first();
                $from = $dataFrom->created_at;
                $to = $input['to'];
            }
            else{
                $dataFrom = Booking::orderBy('created_at','asc')->first();
                $dataTo = Booking::orderBy('created_at','desc')->first();
                $from = $dataFrom->created_at;
                $to = $dataTo->created_at;
            }

            $data = Booking::where('created_at', '>=' , $from)
                                ->where('created_at', '<=', $to)
                                ->orderBy('created_at','desc')->get();
            $arr = [];
            $number = 0;
            foreach ($data as $item){
                $number += 1;
                $item -> specialist_name = $item -> specialist -> name ?? null;
                $item -> department_name = $item -> department -> name ?? null;
                $item -> doctor_name = $item -> doctor -> name ?? null;
                $item -> status_name = $item -> status -> name ?? null;
                $item -> schedule_name = $item -> schedule -> code ?? null;
                $item -> vaccine_name = $item -> vaccine -> name ?? null;
                $item -> STT = $number;
                if($item->type === 'LOGIN'){
                    $item -> customer_name = $item -> user -> name ?? null;
                    $item->address = $item -> user -> address ?? null ;
                    $item->city = $item -> user -> city -> name ?? null ;
                    $item->customer_name = $item -> user -> name ?? null ;
                    $item->phone = $item -> user -> phone ?? null ;
                    $item->email = $item -> user -> email ?? null ;
                    $item->birthday = $item -> user -> date ?? null ;
                    $item->district_code = $item -> user -> district -> name ?? null ;
                    $item->ward_code = $item -> user -> ward -> name ?? null ;
                    $item->birthday = $item -> user -> date ?? null ;
                }
                $arr[] = $item;
            };


        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    return Excel::download(new BookingWithDay($arr, $from, $to, $title), 'booking_' . $date . "_Time_" . $time . '.xlsx');
   }
   public function BookingWithCode(Request $request)
   {
      date_default_timezone_set('Asia/Ho_Chi_Minh');
      $input = $request->all();
      $date  = date('d_m_Y', time());
      $time = date('H-i-s', time());
      $title ='';
      $code = "Code_Trống";
      $dataCheck = "";
      if(!empty($input['code'])){
        $dataCheck = Booking::where('code', $input['code'])->orderBy('created_at','desc')->get();
      }                        
      if($dataCheck){
        $code = $input['code'];
        try {;
            $from = '';
            $to = '';
            $title = "Thông tin booking của mã: " . $input['code'];

            $data = Booking::where('code', $input['code'])->orderBy('created_at','desc')->get();                    
            $arr = [];
            $number = 0;
            foreach ($data as $item){
                $number += 1;
                $item -> specialist_name = $item -> specialist -> name ?? null;
                $item -> department_name = $item -> department -> name ?? null;
                $item -> doctor_name = $item -> doctor -> name ?? null;
                $item -> status_name = $item -> status -> name ?? null;
                $item -> schedule_name = $item -> schedule -> code ?? null;
                $item -> vaccine_name = $item -> vaccine -> name ?? null;
                $item -> STT = $number;
                if($item->type === 'LOGIN'){
                    $item -> customer_name = $item -> user -> name ?? null;
                    $item->address = $item -> user -> address ?? null ;
                    $item->city = $item -> user -> city -> name ?? null ;
                    $item->customer_name = $item -> user -> name ?? null ;
                    $item->phone = $item -> user -> phone ?? null ;
                    $item->email = $item -> user -> email ?? null ;
                    $item->birthday = $item -> user -> date ?? null ;
                    $item->district_code = $item -> user -> district -> name ?? null ;
                    $item->ward_code = $item -> user -> ward -> name ?? null ;
                    $item->birthday = $item -> user -> date ?? null ;
                }
                $arr[] = $item;
            };
            } catch (\Exception $th) {
                throw new HttpException(500, $th->getMessage());
            }
        }else{
            return response()->json([
                'status'  => 400,
                'message' => 'Không tìm thấy code của booking này',
            ],400);
        }
    return Excel::download(new BookingWithDay($arr, $from, $to, $title), 'booking_code_'. $code . '_' . $date . "_Time_" . $time . '.xlsx');
   }
}

