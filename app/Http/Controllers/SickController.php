<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Sick\SickTransformer;
use App\Http\Validators\Sick\InsertSickValidate;
use App\Models\Sick;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        }
        catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
       }
    }
    public function listSick(Request $request)
    {
        $input = $request->all();
        $sick = new sick();
        $data = $sick->searchSick($input);
        // return $this->response->paginator($data, new SickTransformer);
        // if(empty($input['limit'])){
        //     return $this->response->collection($data, new SickTransformer());
        // }
        return $this->response->paginator($data, new SickTransformer);
    }
    public function SickDetail(Request $request, $id)
    {
        $input = $request->all();
        try {
            $sick =  Sick::findOrFail($id);
            return $this->response->item($sick, new SickTransformer());
        } catch (\Exception $th) {
            throw new HttpException($th->statusCode, $th->getMessage());         
        }
    }

    public function updateSick(Request $request, $id)
    {
       $input = $request->all();
       (new InsertSickValidate($input));

      try {
            $data = Sick::find($id);
            if($data){
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
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "Không tìm thấy bệnh",
               ], 400);
            }
        } 
        catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }    
    }

    public function deleteSick($id)
    {
       try {
            $data = Sick::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa bệnh thành công"
        ], 200);
       } 
       catch (Exception $th) {
        $errors = $th->getMessage();
        throw new HttpException(500, $errors);
    }
    }
}
