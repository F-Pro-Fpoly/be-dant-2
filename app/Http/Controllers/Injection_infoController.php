<?php
namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Injection_info;
use App\Supports\TM_Error;
use Illuminate\Http\Request;

class Injection_infoController extends BaseController
{
    public function update_injection_info (Request $request) 
    {
        $input = $request->all();

        if(empty($input['booking_id'])){
            return $this->response->error("Không tồn tại booking này", 400);
        }

        try {
            if(empty($input['id'])) {
                return $this->response->error("Vui lòng nhập id", 400);           
            }
            if(!empty($input['file_new'])) {
                $file = File::create([
                    'url' => $input['file_new'],
                    'created_by' => auth()->user()->id ?? null
                ]);

                $input['file_id'] = $file->id;
            }
            $injection_info = Injection_info::findOrFail($input['id']);
            $injection_info->update_injection_info($input);
            return response()->json([
                'message' => 'Cập nhập thành cônng'
            ], 200);
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);

            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }
}