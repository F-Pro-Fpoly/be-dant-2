<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    // add
    public function addDepartment(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255|unique:department',
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
            $department = Department::create([
                'code' => $request->code,
                'name' => $request->name,
                'specialist_id' => $request->specialist_id,
                'description' => $request->description,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Thêm thành công",
                'data' => [$department]
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
    public function listDepartment(){
        $department = Department::all();
        return response()->json([
            'message' => "Truy xuất thành công",
            'Department' => $department, 201
        ]);
    }
    //select ID
    public function listDepartment_ID($id){
        $department = Department::find($id);
        return response()->json([
            'message' => "Truy xuất thành công",
            'Department' => $department, 201
        ]);
    }
    // update
    public function updateDepartment(Request $request, $id){
        $department = Department::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255',
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
            $department->update([
                'code' => $request->code,
                'name' => $request->name,
                'specialist_id' => $request->specialist_id,
                'description' => $request->description,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Update thành công",
                'data' => [$department]
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
    // delete
    public function deleteDepartment($id){
        $department = Department::find($id);
        $department->delete();
        return response()->json([
            'message' => "Xóa thành công", 201
        ]);
    }

    public function test(){
        return "Department";
    }
}
