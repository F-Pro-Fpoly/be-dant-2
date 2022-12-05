<?php 

namespace App\Http\Controllers;

use App\Models\File;
use App\Supports\TM_Error;
use Illuminate\Http\Request;

class FileController extends BaseController {
    protected $model;

    public function __construct()
    {
        $this->model = new File();
    }

    public function upload_file(Request $request) {

        try {
            if(empty($request->file('file'))){
                return $this->response->errorBadRequest('file không tồn tại');
            }

            $file_name = $request->file('file')->store('images','public');
            return response()->json([
                'message' => "Upload file thành công",
                'data' => [
                    'file_name' => $file_name
                ]
            ],200);
        } catch (\Exception $ex) {
            $err = new TM_Error($ex);
            return $this->response->error($err->getMessage(), $err->getStatusCode());
        }
    }
}