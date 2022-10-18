<?php

namespace App\Http\Controllers;

use App\Models\Histories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Transformer\Histories\HistoriesTransformer;

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
            $histories = Histories::create([
                'file' => $request->file,
                'date_examination' => $request->date_examination,
                'description' => $request->description,
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Thêm histories thành công",
                'data' => [$histories]
            ], 200);
                
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
    public function listHistories(Request $request){
        $input = $request->all();
        $histories = new histories();
        $data = $histories->searchHistories($input);
        return $this->response->paginator($data, new HistoriesTransformer);
    }
     // select ID
    public function listHistories_ID(Request $request, $id){
        $histories = Histories::find($id);
        if($histories){
            return response()->json([
                'status' => 200,
                'message' => 'Truy xuất thành công',
                'data' => [$histories]
            ], 200);
        }
        else{
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy dữ liệu',
                'data' => [$histories]
            ], 400);
        }
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
            if($histories){
                $histories->update([
                    'file' => $request->file,
                    'date_examination' => $request->date_examination,
                    'description' => $request->description,
                    'doctor_id' => $request->doctor_id,
                    'patient_id' => $request->patient_id,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Cập nhật thành công',
                    'data' => [$histories]
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => 'Không tìm thấy dữ liệu',
                ], 400);
            }
            
        } catch(Exception $th){
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function deleteHistories(Request $request, $id){
        try {
            $data = Histories::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa histories thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
