<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Specialist\SpecialistTransformer;
use App\Http\Validators\Specialist\InsertSpecialistValidate;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SpecialistController extends BaseController
{
       // add
       public function addSpecialist(Request $request){
<<<<<<< HEAD
        $validator = Validator::make($request->all(), [
            'code' => 'required|min:5|max:255|unique:specialists',
            'slug' => 'required|min:5|max:255',
            'name' => 'required|min:5|max:255',
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
            //Name
            'name.required' => 'Name không được bỏ trống', 
            'name.min' => 'Name quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Name quá dài!(Tối đa 255 ký tự)',
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
                'name' => $request->name,
                'slug' => "http://127.0.0.1:8000/specialist/".$request->slug,
                'description' => $request->description,
                // "created_by" => auth()->user()->id
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Thêm thành công",
                'data' => [$specialist]
            ];
=======
       
        $input = $request->all();
        (new InsertSpecialistValidate($input));

        try{
            Specialist::create([
                'code' => $input['code'],
                'name' => $input['name'],
                'slug' => Str::slug($input['name']),
                'description' => $input['description'],
                "created_by" => auth()->user()->id
            ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Thêm chuyên khoa thành công"
            ], 200);

>>>>>>> 9a565c0ca4b5aad2da5a289b0d1ddabf9e05ebe9
        } catch(\Throwable $th){
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() 
                ],500
            );
        }
<<<<<<< HEAD
        return response()->json($arrRes, 200);

    }
    // select all
    public function listSpecialist(){
        $specialist = Specialist::all();
        return response()->json([
            'message' => "Truy xuất thành công",
            'specialist' => $specialist, 200
        ]);
    }
    //select ID
    public function listSpecialist_ID($id){
        $specialist = Specialist::find($id);
        return response()->json([
            'message' => "Truy xuất thành công",
            'specialist' => $specialist, 200
        ]);
=======

    }
    // select all
    public function listSpecialist(Request $request){
        $input = $request->all();
        $Specialist = new Specialist();
        $data = $Specialist->searchSpecialist($input);
        return $this->response->paginator($data, new SpecialistTransformer);
>>>>>>> 9a565c0ca4b5aad2da5a289b0d1ddabf9e05ebe9
    }
   
    // update
    public function updateSpecialist(Request $request, $id){
<<<<<<< HEAD
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
        return response()->json($arrRes, 200);

=======
        $input = $request->all();
        (new InsertSpecialistValidate($input));
 
       try {
             $data = Specialist::find($id);
             $data->update([
                 'code' => $input['code'],
                 'name' => $input['name'],
                 'slug' => Str::slug($input['name']),
                 'description' => $input['description'],
                 'updated_by' => auth()->user()->id
             ]);
             return response()->json([
                 'status' => 200,
                 'message' => "Cập nhật chuyên khoa thành công"
            ], 200);
       } catch (\Throwable $th) {
         return response()->json(
             [
                 'status' => 500,
                 'message' => $th->getMessage() 
             ],500
             );
       }
>>>>>>> 9a565c0ca4b5aad2da5a289b0d1ddabf9e05ebe9
    }
    public function deleteSpecialist($id){
<<<<<<< HEAD
        $specialist = Specialist::find($id);
        $specialist->deleted =1;
        // $specialist->deleted_by = auth()->user()->id;
        $specialist->delete();
        return response()->json([
            'status' => 200,
            'message' => "Xóa thành công"
        ], 200);
=======
        try {
            $data = Specialist::find($id);
            $data->deleted = 1;
            $data->deleted_by = auth()->user()->id;
            $data->save();
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa chuyên khoa thành công"
        ], 200);
       } catch (\Throwable $th) {
        return response()->json(
            [
                'status' => 500,
                'message' => $th->getMessage() 
            ],500
            );
       }

>>>>>>> 9a565c0ca4b5aad2da5a289b0d1ddabf9e05ebe9
    }

}
