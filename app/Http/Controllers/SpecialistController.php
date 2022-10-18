<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Specialist\SpecialistTransformer;
use App\Http\Validators\Specialist\InsertSpecialistValidate;
use App\Http\Validators\Specialist\UpdateSpecialistValidate;
use App\Models\Specialist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
                    'message' => "Thêm chuyên khoa thành công",
            ], 200);

        } catch(\Throwable $th){
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() ,
                    'line' => $th->getLine()
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
     // select one
    public function specialistDetail(Request $request, $id){
        $input = $request->all();
        $Specialist =  Specialist::find($id);
        if($Specialist){
            $data = $Specialist->searchSpecialist($input);
            return $this->response->paginator($data, new SpecialistTransformer);
       
        }
        else{
            return response()->json([
                'status'  => 400,
                'message' => 'Không tìm thấy chuyên khoa',
            ],400);
        }
    }
    // update
    public function updateSpecialist(Request $request, $id){
        $input = $request->all();
        (new UpdateSpecialistValidate($input));
 
       try {
            $data = Specialist::find($id);
            if($data){
                $data->update([
                    'code' => $input['code'] ? $input['code'] : $data->code,
                    'name' => $input['name'] ? $input['name'] : $data->name,
                    'slug' => Str::slug($input['name']),
                    'description' => $input['description'] ?? $data->description,
                    'updated_by' => auth()->user()->id
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật chuyên khoa thành công"
               ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Không tìm thấy chuyên khoa",
               ], 400);
            }
       } 
       catch (Exception $th) {
        throw new HttpException(500, $th->getMessage());
    }
    }
    // delete
    public function deleteSpecialist($id){
        try {
            $data = Specialist::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa chuyên khoa thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

}