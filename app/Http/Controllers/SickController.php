<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Sick\SickTransformer;
use App\Http\Validators\Sick\InsertSickValidate;
use App\Models\Sick;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SickController extends BaseController
{
    public function addSick(Request $request)
    {
        $input = $request->all();
        (new InsertSickValidate($input));

        try {

           Sick::create([
                "code" => $input['code'], 
                "name" => $input['name'], 
                "slug" => Str::slug($input['name']),
                "created_by" => auth()->user()->id
           ]);

           return response()->json([
                'status' => 200,
                'message' => "Thêm bệnh thành công"
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
    public function listSick(Request $request)
    {
        $input = $request->all();
        $sick = new sick();
        $data = $sick->searchSick($input);
        return $this->response->paginator($data, new SickTransformer);

    }

    public function updateSick(Request $request, $id)
    {
       $input = $request->all();
       (new InsertSickValidate($input));

      try {
            $data = Sick::find($id);
            $data->update([
                'code' => $input['code'],
                'name' => $input['name'],
                'slug' => Str::slug($input['name']),
                'updated_by' => auth()->user()->id
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Cập nhật bệnh thành công"
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

    public function deleteSick($id)
    {
       try {
            $data = Sick::find($id);
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
