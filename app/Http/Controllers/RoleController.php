<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends BaseController
{
       // add
    public function addRoles(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'code' => 'required|min:5|max:255|unique:roles'
        ],[
            //name
            'name.required' => 'Tên không được bỏ trống', 
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
            //code
            'code.required' => 'Code không được bỏ trống', 
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)'
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
            $roles = Role::create([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Đăng ký thành công",
                'data' => []
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
    public function listRoleAll(){
        $roles = Role::all();
        return response()->json([
            "data" => $roles
        ], 201);
    }
    //select ID
    public function listRoles_ID($id){
        $roles = Role::find($id);
        if($roles){
            return response()->json([
                'status' => 200,
                'message' => "Truy xuất thành công",
                'role' => $roles, 201
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => "Không tìm thấy dữ liệu",
                'role' => $roles, 400
            ]);
        }
    }
    // update
    public function updateRoles(Request $request, $id){
        $roles = Role::find($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'code' => 'required|min:5|max:255|unique:roles'
        ],[
            //name
            'name.required' => 'Tên không được bỏ trống', 
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
           //code
           'code.required' => 'Code không được bỏ trống', 
           'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
           'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
           'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)'
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
            if($roles){
                $roles->update([
                    'code' => $request->code,
                    'name' => $request->name
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật thành công"
            ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "không tìm thấy dữ liệu"
            ], 400);
            }
        } catch(Exception $th){
            throw new HttpException(500,$th->getMessage());
        }
    }
    // delete
    public function deleteRoles($id){
        try {
            $data = Role::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa Role thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function test(){
        return "helolo";
    }
}
    

