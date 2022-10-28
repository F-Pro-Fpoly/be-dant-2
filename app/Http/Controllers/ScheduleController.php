<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Schedule\ScheduleDetailTransformer;
use App\Models\Schedule;
use AWS\CRT\HTTP\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Transformer\Schedule\ScheduleTransformer;
use App\Http\Validators\Schedule\CreateScheduleValidate;
use App\Models\timeslotDetail;
use DateTime;

class ScheduleController extends BaseController
{
    // add
    public function addSchedule(Request $request){
        $input = $request->all();
        (new CreateScheduleValidate($input));
        /**
         * {
         *  "date": "",
         *  "department_id": 1,
         *  "description": "dagsgkjsfjgshfui"
         * }
         */
        $date = date("YmdHis", time());
        $time = new DateTime($input['date']);
        try {
            $code = "LICH{$date}";
            // dd(date_format($time, "Y-m-d"));
            Schedule::create([
                "code" => $code,
                "date" => date_format($time, "Y-m-d"),
                "department_id" => $input['department_id'],
                "description" => $input['description'] ?? null
            ]);

            return response()->json([
                'message' => "Thêm lịch khám thành công"
            ],200);
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
     // select all
    public function listSchedule(Request $request){
        $input = $request->all();
        $schedule = new Schedule();
        $data = $schedule->searchSchedule($input);
        return $this->response->paginator($data, new ScheduleTransformer);
    }

    public function listScheduleDetail(Request $request) {
        $input = $request->all();
        try {
            $timeSlotDetail = TimeslotDetail::model();
            if(!empty($input['schedule_id'])){
                $timeSlotDetail->where("schedule_id",$input['schedule_id'] );
            }
            $timeSlotDetail = $timeSlotDetail->orderBy("id", 'desc')->get();
            // return response()->json([
            //     "data" => $timeSlotDetail 
            // ],200);

            return $this->response->collection($timeSlotDetail, new ScheduleDetailTransformer);
        } catch (\Throwable $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
     // select ID
    public function listSchedule_ID(Request $request, $id){
        $schedule = Schedule::find($id);
        if($schedule){
            return response()->json([
                'status' => 200,
                'message' => 'Truy xuất thành công',
                'data' => [$schedule]
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy dữ liệu",
           ], 400);
        }
        
    }
    // update
    public function updateSchedule(Request $request, $id){
        $schedule = Schedule::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255',
            'date' => 'required',
            'description' => 'required|min:8|max:255',
            'department_id' => 'required',
        ],[
            //code
            'code.required' => 'Code không được bỏ trống', 
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            //date
            'date.required' => 'Date không được bỏ trống',
            //description
            'description.required' => 'Description không được bỏ trống', 
            'description.min' => 'Description quá ngắn!(Tối thiểu 8 ký tự)',
            'description.max' => 'Description quá dài!(Tối đa 255 ký tự)',
            //department
            'department_id.required' => 'Department không được bỏ trống'
        ]);
        
        if($validator->fails()){
            $arrRes = [
                'errCode' => 1,
                'message' => "Lỗi validate dữ liệu",
                'data' => $validator->errors()
            ];
            return response()->json($arrRes, 402);
        }

        try{
            if($schedule){
                $schedule->update([
                'code' => $request->code,
                'date' => $request->date,
                'description' => $request->description,
                'department_id' => $request->department_id,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật bệnh thành công"
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Không tìm thấy bệnh",
                ], 400);
            }
            
        } 
        catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }
    public function deleteSchedule(Request $request, $id){
        try {
            $data = Schedule::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa thành công"
        ], 200);
        } 
        catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    
}
