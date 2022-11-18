<?php

namespace App\Http\Controllers;

use App\Http\Transformer\banner\BannerTransformer;
use App\Http\Validators\Banner\CreateBannerValidate;
use App\Models\Banner;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;
class BannerController extends BaseController
{
    public function addBanner(Request $request)
    {
        $input = $request->all();
        (new CreateBannerValidate($input));

        try {


            $get_img = $request->file('image');   
            
            if($get_img) {
                foreach($get_img as $key => $image) {
                  return $image;
                  die;
                    $file  = $image->store('images','public');   
             
                }            
            }
            
            Banner::create([
                'code' => $input['code'],
                'name' => $input['name'],
                'status' =>$input['status'],
                'description' => $input['description'],
                'image' => $file,
                "created_by" => auth()->user()->id
            ]);
            return response()->json([
                "message" => "Thêm banner thành công",
                "status" => 201
            ],201);
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }


    public function updateBanner(Request $request, $id){
        $input = $request->all();
        // (new PageUpdatePageValidate($input));
       try {
            $data = banner::findOrFail($id);

            if(!empty($input['image'])){
                $file  = $request->file('image')->store('images','public');    
                $data->image  = $file;
                $data->save();
            }
            $data->update([
                'code' =>  Arr::get($input, 'code',  $data->code),
                'name' =>  Arr::get($input, 'name',  $data->name),
                'status' =>Arr::get($input, 'status',  $data->status),
                'description' => Arr::get($input, 'description',  $data->description),    
                'updated_by' => auth()->user()->id,            
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Cập nhật banner thành công"
            ], 200);        
       } 
       catch (\Exception $th) {
        throw new HttpException(500, $th->getMessage());
        }
    }


    //  // select one
    public function  bannerDetail($id){
        try {
            $data =  banner::findOrFail($id);              
            return $this->response->item($data, new BannerTransformer); 
        
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    public function listBanner(Request $request)
    {
        $input = $request->all();
        try {
            $banner = new Banner();
            $data = $banner->searchBanner($input); 
            return $this->response->paginator($data, new BannerTransformer);            
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage()) ;
        }
    }
}
