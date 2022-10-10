<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Transformer\Specialist\SpecialistTransformer;
use App\Http\Validators\Specialist\InsertSpecialistValidate;
use App\Http\Validators\Specialist\UpdateSpecialistValidate;
use App\Models\Specialist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class SpecialistController extends BaseController
{
       // add
       public function addSpecialist(Request $request){
        $input = $request->all();
        (new InsertSpecialistValidate($input));
        try{
            $specialist = Specialist::create([
                'code' => $request->code,
                'name' => $request->name,
                'slug' => "/specialist/".$request->slug,
                'description' => $request->description,
                'created_by' => auth()->user()->id,
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Thêm thành công",
                'specialist' => [$specialist]
            ];
            return response()->json($arrRes, 200);
        }
        catch(\Throwable $th){
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() 
                ],500
            );
        }
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

    }
   
    // update
    public function updateSpecialist(Request $request, $id){
        $specialist = Specialist::find($id);
        $input = $request->all();
        (new UpdateSpecialistValidate($input));          

        try{
            $specialist->update([
                'code' => $request->code,
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'updated_by' => auth()->user()->id
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
            return response()->json($arrRes, 500);
        }
        return response()->json($arrRes, 200);
    }
    public function deleteSpecialist($id){
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
    }

}
