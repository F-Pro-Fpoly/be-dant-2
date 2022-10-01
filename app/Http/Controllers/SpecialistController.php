<?php

namespace App\Http\Controllers;

use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialistController extends Controller
{
       // add
       public function addSpecialist(Request $request){
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255|unique:specialist',
            'slug' => 'required|min:5|max:255',
            'description' => 'required|min:8|max:255',
        ],[
            //code
            'code.required' => 'Code không được bỏ trống', 
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
            //slug
            'slug.required' => 'Slug không được bỏ trống', 
            'slug.min' => 'Slug quá ngắn!(Tối thiểu 5 ký tự)',
            'slug.max' => 'Slug quá dài!(Tối đa 255 ký tự)',
            //description
            'description.required' => 'Description không được bỏ trống', 
            'description.min' => 'Description quá ngắn!(Tối thiểu 5 ký tự)',
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
            $specialist = Specialist::create([
                'code' => $request->code,
                'slug' => $request->slug,
                'description' => $request->description,
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
    public function listSpecialist(){
        $specialist = Specialist::all();
        return response()->json([
            'message' => "Truy xuất thành công",
            'specialist' => $specialist, 201
        ]);
    }
    //select ID
    public function listSpecialist_ID($id){
        $specialist = Specialist::find($id);
        return response()->json([
            'message' => "Truy xuất thành công",
            'specialist' => $specialist, 201
        ]);
    }
    // update
    public function updateSpecialist(Request $request, $id){
        $specialist = Specialist::find($id);
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255|unique:specialist',
            'slug' => 'required|min:5|max:255',
            'description' => 'required|min:8|max:255',
        ],[
             //code
             'code.required' => 'Code không được bỏ trống', 
             'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
             'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
             'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
             //slug
             'slug.required' => 'Slug không được bỏ trống', 
             'slug.min' => 'Slug quá ngắn!(Tối thiểu 5 ký tự)',
             'slug.max' => 'Slug quá dài!(Tối đa 255 ký tự)',
             //description
             'description.required' => 'Description không được bỏ trống', 
             'description.min' => 'Description quá ngắn!(Tối thiểu 5 ký tự)',
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
            $specialist->update([
                'code' => $request->code,
                'slug' => $request->slug,
                'description' => $request->description,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Update thành công",
                'data' => [$request->all(), $specialist]
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
    public function deleteSpecialist($id){
        $specialist = Specialist::find($id);
        $specialist->delete();
        return response()->json([
            'message' => "Xóa thành công", 201
        ]);
    }

    public function test(){
        return "Specialist";
    }
}
