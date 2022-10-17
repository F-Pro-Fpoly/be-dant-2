<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Department\departmentTransformer;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DepartmentController extends BaseController
{
    // add
    public function addDepartment(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255|unique:departments',
            'name' => 'required|min:5|max:255',
            'specialist_id' => 'required',
            'description' => 'required|min:8|max:255',
        ],[
            //code
            'code.required' => 'Code không được bỏ trống', 
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
            //name
            'name.required' => 'Name không được bỏ trống', 
            'name.min' => 'Name quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Name quá dài!(Tối đa 255 ký tự)',
            //description
            'description.required' => 'Description không được bỏ trống', 
            'description.min' => 'Description quá ngắn!(Tối thiểu 8 ký tự)',
            'description.max' => 'Description quá dài!(Tối đa 255 ký tự)',
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
            $department = Department::create([
                'code' => $request->code,
                'name' => $request->name,
                'specialist_id' => $request->specialist_id,
                'description' => $request->description,
                "created_by" => auth()->user()->id
            ]);
            return response()->json([
                'message' => 'Thêm thành công',
                'data' => [$department]
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
    public function listDepartment(Request $request){
        $input = $request->all();
        $Department = new Department();
        $data = $Department->searchDepartment($input);
        return $this->response->paginator($data, new departmentTransformer);
    }
    //select ID
    public function listDepartment_ID($id){
        try {
            $department = Department::findOrFail($id);
            return $this->response->item($department, new departmentTransformer());
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }    
    }
    // update
    public function updateDepartment(Request $request, $id){
        $department = Department::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255|unique:departments',
            'name' => 'required|min:5|max:255',
            'specialist_id' => 'required',
            'description' => 'required|min:8|max:255',
        ],[
             //code
             'code.required' => 'Code không được bỏ trống', 
             'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
             'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
             //name
             'name.required' => 'Name không được bỏ trống', 
             'name.min' => 'Name quá ngắn!(Tối thiểu 5 ký tự)',
             'name.max' => 'Name quá dài!(Tối đa 255 ký tự)',
             //specialist
             'specialist.required' => 'Slug không được bỏ trống', 
             //description
             'description.required' => 'Description không được bỏ trống', 
             'description.min' => 'Description quá ngắn!(Tối thiểu 8 ký tự)',
             'description.max' => 'Description quá dài!(Tối đa 255 ký tự)',
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
            if($department){
                $department->update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'specialist_id' => $request->specialist_id,
                    'description' => $request->description,
                ]);
                return response()->json([
                    'message' => 'Thêm thành công',
                    'data' => [$department]
                ], 200);
            }
            else{
                return response()->json([
                    'message' => 'Không tìm thấy dữ liệu',
                    'data' => $th->getMessage(),
                ], 500);
            }

        } catch(\Throwable $th){
            $arrRes = [
                'errCode' => 0,
                'message' => "Lỗi phía server",
                'data' => $th->getMessage()
            ];
        }
        return response()->json($arrRes, 201);

    }
    // delete
    public function deleteDepartment($id){
        try {
            $data = Department::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa Department thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function test(){
        return "Department";
    }
}
