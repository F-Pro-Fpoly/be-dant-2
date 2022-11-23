<?php
namespace App\Http\Controllers;

use App\Http\Transformer\VaccineCategory\VaccineCategoryTransformer;
use App\Supports\TM_Error;
use Illuminate\Http\Request;
use App\Models\Vaccine_category;

class VaccineCategoryController extends BaseController 
{
    public function list(Request $request) {
        $input = $request->all();

        try {
            $vaccine_cate = (new Vaccine_category())->search_vaccine_category($input);

            if(!empty($input['limit'])) {
                return $this->response->paginator($vaccine_cate, new VaccineCategoryTransformer());
            }

            return $this->response->collection($vaccine_cate, new VaccineCategoryTransformer());
        } catch (\Exception $ex) {
            $ex_processed = new TM_Error($ex);
            return $this->response->error($ex_processed->getMessage(), $ex_processed->getStatusCode());
        }
    }

    public function create_vaccine_category(Request $request) {
        $input = $request->all();
        try {
            if(!empty($input['parent'])) {
                $parent_id = $input['parent']['parent_id'];
                if(!empty($parent_id)) {
                    $input['parent_id'] = $parent_id;
                }
                unset($input['parent']);
            }
            $vaccine_cate = Vaccine_category::create($input);
            return response()->json([
                'message' => "thêm danh mục thành công"
            ], 200);
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);
            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }


    public function update(Request $request, $id) {
        $input = $request->all();
        try {
            if(!empty($input['parent'])) {
                $parent_id = $input['parent']['parent_id'];
                if(!empty($parent_id)) {
                    $input['parent_id'] = $parent_id;
                }
                unset($input['parent']);
            }
            $vaccine_cate = Vaccine_category::findOrFail($id);
            $vaccine_cate->update($input);
            return response()->json([
                'message' => "thêm danh mục thành công"
            ], 200);
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);
            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }
}