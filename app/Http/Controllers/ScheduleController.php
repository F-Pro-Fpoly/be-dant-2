<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use AWS\CRT\HTTP\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    // add
    public function addSchedule(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255|unique:schedule',
            'date' => 'required',
            'description' => 'required|min:8|max:255',
            'department_id' => 'required',
        ],[
            //code
            'code.required' => 'Code không được bỏ trống', 
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
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
            $schedule = Schedule::create([
                'code' => $request->code,
                'date' => $request->date,
                'description' => $request->description,
                'department_id' => $request->department_id,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Thêm thành công",
                'data' => [$schedule]
            ];
        } catch(\Throwable $th){
            $arrRes = [
                'errCode' => 0,
                'message' => "Lỗi phía server",
                'data' => $th->getMessage()
            ];
        }
        return response()->json($arrRes, 201);
    }
     // select all
    public function listSchedule(){
        $schedule = Schedule::all();
        return response()->json([
            'message' => 'Truy xuất thành công',
            'data' => [$schedule]
        ]);
    }
     // select ID
    public function listSchedule_ID(Request $request, $id){
        $schedule = Schedule::find($id);
        return response()->json([
            'message' => 'Truy xuất thành công',
            'data' => [$schedule]
        ]);
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
            $schedule->update([
                'code' => $request->code,
                'date' => $request->date,
                'description' => $request->description,
                'department_id' => $request->department_id,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Update thành công",
                'data' => [$schedule]
            ];
        } catch(\Throwable $th){
            $arrRes = [
                'errCode' => 0,
                'message' => "Lỗi phía server",
                'data' => $th->getMessage()
            ];
        }
        return response()->json($arrRes, 201);
    }
    public function deleteSchedule(Request $request, $id){
        $schedule = Schedule::find($id);
        $schedule->delete();
        return response()->json([
            'message' => 'Xóa thành công',
            'data' => [$schedule]
        ]);
    }

    
}
