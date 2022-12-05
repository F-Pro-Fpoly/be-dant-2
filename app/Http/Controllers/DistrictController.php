<?php
namespace App\Http\Controllers;

use App\Http\Transformer\City\CityTransformer;
use App\Http\Transformer\District\DistrictTransformer;
use App\Http\Transformer\Ward\WardTransformer;
use App\Models\City;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DistrictController extends BaseController {
    public function index(Request $request) {
        $input = $request->all();
        try {
            $districts = (new District())->search_district($input);

            if(isset($input['limit'])) {
                return $this->response->paginator($districts, new DistrictTransformer());
            }else{
                return $this->response->collection($districts, new DistrictTransformer());
            }
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function get_wards (Request $request) {
        $input = $request->all();
        try {
            $wards = (new Ward())->search_ward($input);

            if(isset($input['limit'])) {
                return $this->response->paginator($wards, new WardTransformer());
            }else{
                return $this->response->collection($wards, new WardTransformer());
            }
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}