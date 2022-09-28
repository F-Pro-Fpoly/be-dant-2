<?php

namespace App\Http\Controllers;

use App\Models\National;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NationalController extends Controller
{
       // add
       public function addNational(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'code' => 'required|min:5|max:255|unique:nationals',
            'slug' => 'required|min:5|max:255'
        ],[
            //name
            'name.required' => 'Tên không được bỏ trống', 
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
            //code
            'code.required' => 'Code không được bỏ trống', 
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
            //slug
            'slug.required' => 'Code không được bỏ trống', 
            'slug.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'slug.max' => 'Code quá dài!(Tối đa 255 ký tự)',
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
            $national = National::create([
                'name' => $request->name,
                'code' => $request->code,
                'slug' => $request->slug
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Thêm thành công",
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
    public function listNational(){
        $national = National::all();
        return response()->json([
            'message' => "Truy xuất thành công",
            'national' => $national, 201
        ]);
    }
    //select ID
    public function listNational_ID($id){
        $national = National::find($id);
        return response()->json([
            'message' => "Truy xuất thành công",
            'national' => $national, 201
        ]);
    }
    // update
    public function updateNational(Request $request, $id){
        $national = National::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'code' => 'required|min:5|max:255',
            'slug' => 'required|min:5|max:255'
        ],[
            //name
            'name.required' => 'Tên không được bỏ trống', 
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
            //code
            'code.required' => 'Code không được bỏ trống', 
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
            //slug
            'slug.required' => 'Code không được bỏ trống', 
            'slug.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'slug.max' => 'Code quá dài!(Tối đa 255 ký tự)',
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
            $national = National::create([
                'name' => $request->name,
                'code' => $request->code,
                'slug' => $request->slug
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Update thành công",
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
    // delete
    public function deleteNational($id){
        $national = National::find($id);
        $national->delete();
        return response()->json([
            'message' => "Xóa thành công", 201
        ]);
    }

    public function test(){
        return "National";
    }
}
