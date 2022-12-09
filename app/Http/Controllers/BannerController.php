<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Banner\BannerTransformer;
use App\Http\Validators\Banner\CreateBannerValidate;
use App\Models\Banner;
use App\Models\banner_detail;
use App\Models\File;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;
class BannerController extends BaseController
{
    public function addBanner(Request $request)
    {
        $input = $request->all();
        // (new CreateBannerValidate($input));
        try {
                
            if(!empty($input['image'])){
                $file = $request->file('image')->store('images','public');          
                $file = File::create([
                    'alt' => null,
                    'url' => $file?? null
                ]);
    
                $file_id = $file->id;
            }

             Banner::create([          
                'name'        => $input['name'],
                'status'      =>$input['status'],
                'description' =>$input['description'],
                'button'      =>$input['button'],
                'link'        =>$input['link'],
                'thumnail_id' =>$file_id,
                "created_by"  => auth()->user()->id
            ]);

            return response()->json([
                "message" => "Thêm slide thành công",
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
                'name' =>  Arr::get($input, 'name',  $data->name),
                'status' =>Arr::get($input, 'status',  $data->status),
                'description' => Arr::get($input, 'description',  $data->description),    
                'link' => Arr::get($input, 'link',  $data->link),    
                'button' => Arr::get($input, 'button',  $data->button),    
                'updated_by' => auth()->user()->id,            
            ]);
            return response()->json([
                'status' => 200,
                'message' => "Cập nhật silde thành công"
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

    public function listBannerNormal(Request $request)
    {
        $input = $request->all();
        try {
            $banner = new Banner();
            $data = $banner->searchBannerNormal($input); 
            return $this->response->collection($data, new BannerTransformer);            
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage()) ;
        }
    }

    public function  deleteBanner($id){
        try {
            $data = Banner::findOrFail($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa config thành công"
        ], 200);
        } 
        catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

}
