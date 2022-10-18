<?php

namespace App\Http\Controllers;

use App\Models\National;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Transformer\National\NationalTransformer;

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

            return response()->json([
                'status' => 200,
                'message' => "Thêm national thành công"
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
    public function listNational(Request $request){
        $input = $request->all();
        $national = new national();
        $data = $national->searchNational($input);
        return $this->response->paginator($data, new NationalTransformer);
    }
    //select ID
    public function listNational_ID($id){
        $national = National::find($id);
        if($national){
            return response()->json([
                'message' => 'Truy xuất thành công',
                'data' => [$national]
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
    public function updateNational(Request $request, $id){
        $national = National::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:255',
            'code' => 'required|min:5|max:255',
            // 'code' => 'required|min:5|max:255|unique:nationals',
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
            if($national){
                $national->update([
                    'name' => $request->name,
                    'code' => $request->code,
                    'slug' => $request->slug
                ]);

                return response()->json([
                    'status'  => 200,
                    'message' => 'Cập nhật thành công',
                ],400);
            }
            else{
                return response()->json([
                    'status'  => 400,
                    'message' => 'Không tìm thấy dữ liệu',
                    'data' => $th->getMessage()
                ],400);
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
    public function deleteNational($id){
        try {
            $data = National::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa National thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function test(){
        return "National";
    }
}
