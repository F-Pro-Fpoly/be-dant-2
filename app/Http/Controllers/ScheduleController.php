<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use AWS\CRT\HTTP\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Transformer\Schedule\ScheduleTransformer;

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
    public function listSchedule(Request $request){
        $input = $request->all();
        $schedule = new Schedule();
        $data = $schedule->searchSchedule($input);
        return $this->response->paginator($data, new ScheduleTransformer);
    }
     // select ID
    public function listSchedule_ID(Request $request, $id){
        $schedule = Schedule::find($id);
        if($schedule){
            return response()->json([
                'message' => 'Truy xuất thành công',
                'data' => [$schedule]
            ]);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy dữ liệu",
                'data' => $th->getMessage()
           ], 200);
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
                    'data' => $th->getMessage()
                ], 200);
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
