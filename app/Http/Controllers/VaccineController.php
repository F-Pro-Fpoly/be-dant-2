<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Vaccine\VaccineTransformer;
use App\Http\Validators\Vaccine\InsertVaccineValidate;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VaccineController extends BaseController
{
    public function addVaccine(Request $request)
    {
        $input = $request->all();
        (new InsertVaccineValidate($input));

        try {

           Vaccine::create([
                "code" => $input['code'], 
                "name" => $input['name'], 
                "slug" => Str::slug($input['name']),
                "price" => $input['price'],
                "description" => $input['description'],
                "sick_id" => $input['sick_id'],
                "national_id" => $input['national_id'],
                "created_by" => auth()->user()->id
           ]);

           return response()->json([
                'status' => 200,
                'message' => "Thêm Vaccine thành công"
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
    public function listVaccine(Request $request)
    {
        $input = $request->all();
        $vaccine = new Vaccine();
        $data = $vaccine->searchVaccine($input);
        return $this->response->paginator($data, new VaccineTransformer);

    }

    public function updateVaccine(Request $request, $id)
    {
       $input = $request->all();
       (new InsertVaccineValidate($input));

      try {
            $data = Vaccine::find($id);
            $data->update([
                'code' => $input['code'],
                'name' => $input['name'],
                'slug' => Str::slug($input['name']),
                "price" => $input['price'],
                "description" => $input['description'],
                "sick_id" => $input['sick_id'],
                "national_id" => $input['national_id'],
                'updated_by' => auth()->user()->id
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Cập nhật Vaccin thành công"
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

    public function deleteVaccine($id)
    {
       try {
            $data = Vaccine::find($id);
            $data->deleted =1;
            $data->deleted_by = auth()->user()->id;
            $data->save();
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa bệnh thành công"
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
