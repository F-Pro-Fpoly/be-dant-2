<?php
namespace App\Http\Controllers;

use App\Http\Transformer\City\CityTransformer;
use App\Models\City;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CityController extends BaseController {
    public function index(Request $request) {
        $input = $request->all();

        try {
            $cities = (new City())->search_city($input);

            if(isset($input['limit'])) {
                return $this->response->paginator($cities, new CityTransformer());
            }else{
                return $this->response->collection($cities, new CityTransformer());
            }
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}