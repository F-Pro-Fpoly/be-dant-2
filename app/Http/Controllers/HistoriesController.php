<?php

namespace App\Http\Controllers;

use App\Models\Histories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HistoriesController extends Controller
{
    // add
    public function addHistories(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'date_examination' => 'required',
            'description' => 'required',
            'doctor_id' => 'required',
            'patient_id' => 'required',
        ],[
            //File
            'file.required' => 'File không được bỏ trống', 
            //date
            'date_examination.required' => 'Ngày kiểm tra không được bỏ trống',
            //description
            'description.required' => 'Description không được bỏ trống', 
            //doctor_id
            'doctor_id.required' => 'Mã Bác sĩ không được bỏ trống',
            //patient_id
            'patient_id.required' => 'Mã bệnh nhân không được bỏ trống'
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
            $schedule = Histories::create([
                'file' => $request->file,
                'date_examination' => $request->date_examination,
                'description' => $request->description,
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
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
    public function listHistories(){
        $histories = Histories::all();
        return response()->json([
            'message' => 'Truy xuất thành công',
            'data' => [$histories]
        ]);
    }
     // select ID
    public function listHistories_ID(Request $request, $id){
        $histories = Histories::find($id);
        return response()->json([
            'message' => 'Truy xuất thành công',
            'data' => [$histories]
        ]);
    }
    // update
    public function updateHistories(Request $request, $id){
        $histories = Histories::find($id);
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'date_examination' => 'required',
            'description' => 'required',
            'doctor_id' => 'required',
            'patient_id' => 'required',
        ],[
            //File
            'file.required' => 'File không được bỏ trống', 
            //date
            'date_examination.required' => 'Ngày kiểm tra không được bỏ trống',
            //description
            'description.required' => 'Description không được bỏ trống', 
            //doctor_id
            'doctor_id.required' => 'Mã Bác sĩ không được bỏ trống',
            //patient_id
            'patient_id.required' => 'Mã bệnh nhân không được bỏ trống'
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
            $histories->update([
                'file' => $request->file,
                'date_examination' => $request->date_examination,
                'description' => $request->description,
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Update thành công",
                'data' => [$histories]
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
    public function deleteHistories(Request $request, $id){
        $histories = Histories::find($id);
        $histories->delete();
        return response()->json([
            'message' => 'Xóa thành công',
            'data' => [$histories]
        ]);
    }
}
