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

        } catch(\Throwable $th){
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() 
                ],500
            );
        }

    }
    // select all
    public function listSpecialist(Request $request){
        $input = $request->all();
        $Specialist = new Specialist();
        $data = $Specialist->searchSpecialist($input);
        return $this->response->paginator($data, new SpecialistTransformer);
    }
   
    // update
    public function updateSpecialist(Request $request, $id){
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
    }
    // delete
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