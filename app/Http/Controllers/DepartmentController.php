<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Department\departmentTransformer;
use App\Http\Validators\Department\UpdateDepartmentValidate;
use App\Models\Department;
use Exception;
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
                'status' => 200,
                'message' => 'Thêm thành công',
            ], 200);
        } catch(Exception $th){
            throw new HttpException(500, $th->getMessage());
        }

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
        $input = $request->all();
        (new UpdateDepartmentValidate($input));
        try {
            $department = Department::findOrFail($id);
            $department->updateDepartment($input);

            return response()->json([
                "message" => "cập nhập thành công"
            ], 200);
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
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
