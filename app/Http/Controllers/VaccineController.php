<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Vaccine\VaccineTransformer;
use App\Http\Validators\Vaccine\InsertVaccineValidate;
use App\Models\File;
use App\Models\Vaccine;
use App\Supports\TM_Error;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VaccineController extends BaseController
{
    public function addVaccine(Request $request)
    {
        $input = $request->all();
        (new InsertVaccineValidate($input));

        try {

            if(!empty($input['sick_ids'])) {
                $sick_ids = json_encode($input['sick_ids']);
            }
            if(!empty($input['category_ids'])) {
                $category_ids = json_encode($input['category_ids']);
            }
            if(!empty($input['img_link'])) {
                $file = File::create([
                    "alt" => $input['img_alt'] ?? null,
                    "url" => $input['img_link'],
                    "created_by" => auth()->user()->id
                ]);
            }
            Vaccine::create([
                "code" => $input['code'], 
                "name" => $input['name'], 
                "slug" => $input['slug']??Str::slug($input['name']),
                "price" => $input['price'],
                "description" => $input['description'] ?? null,
                "national_id" => $input['national_id'] ?? null,
                "created_by" => auth()->user()->id,
                "sick_ids" => $sick_ids ?? "[]",
                "category_ids" => $category_ids ?? "[]",
                "img_id" => $file->id ?? null,
                'is_active' => $input['is_active'] ?? 1
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Thêm Vaccine thành công"
            ], 200);
        }
        catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }
    public function listVaccine(Request $request)
    {
        $input = $request->all();
        $vaccine = new Vaccine();
        $data = $vaccine->searchVaccine($input, 5);
        return $this->response->paginator($data, new VaccineTransformer);
    }
    public function listVaccineNormal(Request $request)
    {
        $input = $request->all();
        $vaccine = new Vaccine();
        $data = $vaccine->searchVaccine($input);
        return $this->response->collection($data, new VaccineTransformer);
    }
    public function VaccineDetailNormal($id){
        try {
            $data =  Vaccine::findOrFail($id);              
            return $this->response->item($data, new VaccineTransformer); 
          
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    public function show($id, Request $request) {
        $input = $request->all();

        try {
            $vaccine = Vaccine::findOrFail($id);

            return $this->response->item($vaccine, new VaccineTransformer());
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);
            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }

    public function updateVaccine(Request $request, $id)
    {
       $input = $request->all();
    //    (new InsertVaccineValidate($input));

      try {
            if(!empty($input['sick_ids'])) {
                $sick_ids = json_encode($input['sick_ids']);
            }
            if(!empty($input['category_ids'])) {
                $category_ids = json_encode($input['category_ids']);
            }
            if(!empty($input['img_link'])) {
                $file = File::create([
                    "alt" => $input['img_alt'] ?? null,
                    "url" => $input['img_link'],
                    "created_by" => auth()->user()->id
                ]);
            }
            $data = Vaccine::findOrFail($id);
            if($data){
                $data->update([
                    'code' => $input['code'] ?? $data->code,
                    'name' => $input['name'] ?? $data->name,
                    'slug' => $input['slug'] ?? $data->slug ,
                    "price" => $input['price'] ?? $data->price,
                    "description" => $input['description'] ?? $data->description,
                    "national_id" => $input['national_id'] ?? $data->national_id,
                    'updated_by' => auth()->user()->id,
                    'sick_ids' => $sick_ids ?? $data->sick_ids,
                    'category_ids' => $category_ids ?? $data->category_ids,
                    'img_id' => !empty($file) ? $file->id : $data->img_id,
                    'is_active' => $input['is_active'] ?? $data->is_active
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật Vaccin thành công"
                ], 200);
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Không tìm thấy Vaccin",
                ], 400);
            }
      }catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }      
    }

    public function deleteVaccine($id)
    {
       try {
            $data = Vaccine::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa Vaccin thành công"
        ], 200);
       } 
       catch (Exception $th) {
        $errors = $th->getMessage();
        throw new HttpException(500, $errors);
        }
    }
}