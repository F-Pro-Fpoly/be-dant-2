<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Specialist\SpecialistTransformer;
use App\Http\Validators\Specialist\InsertSpecialistValidate;
use App\Http\Validators\Specialist\UpdateSpecialistValidate;
use App\Models\Specialist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'status' => $input['status'],
                'is_feature' => $input['is_feature'],
                'slug' => Str::slug($input['name']),
                'description' => $input['description'],
                "created_by" => auth()->user()->id
            ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Thêm chuyên khoa thành công",
            ], 200);

        } catch(Exception $th){
            throw new HttpException(500, $th->getMessage());
        }

    }
    // select all
    public function listSpecialist(Request $request){
        $input = $request->all();
        
        $Specialist = new Specialist();
        if(!empty($input['get'])){
            if($input['get'] == 'all'){
                $Specialist = $Specialist->all();
                return response()->json([
                    'data' => $Specialist
                ], 200);
            }
        }
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
                    'is_feature' =>$input['is_feature'] ? $input['is_feature'] : $data->is_feature,
                    'slug' => Str::slug($input['name']),
                    'description' => $input['description'] ?? $data->description,
                    'status' => $input['status'] ?? $data->status,
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

    // không cần đăng nhập và không paginator
    public function listSpecialistNormal(Request $request){
        $input = $request->all();
        try {
            $specialist = new Specialist;
            $data = $specialist->searchSpecialist($input);
            return $this->response->collection($data, new SpecialistTransformer);
        } 
        catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }
    // top 4 specialist is_feature
    public function listSpecialistFeature5(Request $request){
        try {       
            $page = Specialist::select('specialists.*','files.url as thumbnail_name')
                            ->join('files', 'files.id', 'specialists.thumbnail_id')
                            ->where('specialists.is_feature', "=", 1)
                            ->where('specialists.status', '=', 1)
                            ->orderBy('specialists.updated_at','ASC')->limit(7)->get();
            return response()->json([
                'status' => 200,
                'data' => $page,
            ], 200);
        } 
        catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

}