<?php

namespace App\Http\Controllers;
use App\Http\Transformer\setting\SettingTransformer;
use App\Http\Validators\Settings\InsertSettingValidate;
use App\Models\setting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SettingController extends BaseController
{
      // add
      public function addSetting(Request $request){
     
        $input = $request->all();
        (new InsertSettingValidate($input));

        try{
            setting::create([
                'code' => $input['code'],
                'status' => $input['status'] ?? 1,
                'description' => $input['description'],    
                "created_by" => auth()->user()->id
            ]);

                return response()->json([
                    'status' => 200,
                    'message' => "Thêm cofig thành công",
            ], 200);

        } catch(\Throwable $th){
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage() ,
                    'line' => $th->getLine()
                ],500
            );
        }

    }
    // select all
    public function listSetting(Request $request){
        $input = $request->all();
        try {
            $setting = new setting();
            $data = $setting->searchSetting($input); 
            return $this->response->paginator($data, new SettingTransformer);            
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage()) ;
        }
    }
    //  // select one
    public function settingDetail($id){
        try {
            $data =  setting::findOrFail($id);              
            return $this->response->item($data, new SettingTransformer); 
          
        } catch (\Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }
    // // update
    public function updateSetting(Request $request, $id){
        $input = $request->all();
        // (new PageUpdatePageValidate($input));
       try {
            $data = setting::findOrFail($id);
                $data->update([

                    'code' =>  Arr::get($input, 'code',  $data->name),
                    'status' =>Arr::get($input, 'status',  $data->status),
                    'description' => Arr::get($input, 'description',  $data->description),    
                    'updated_by' => auth()->user()->id,            
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Cập nhật config thành công"
               ], 200);        
       } 
       catch (\Exception $th) {
        throw new HttpException(500, $th->getMessage());
    }
    }
    // // delete
    public function deleteSetting($id){
        try {
            $data = setting::findOrFail($id);
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
    // list page all soft by sort
    public function listSettingNormal(){
        try {       

            //logo
            $logo = setting::select('description')->where('code', 'logo')->first();
            view()->share('logo', $logo);

            //favicon
            $favicon = setting::select('description')->where('code', 'favicon')->first();
            view()->share('favicon', $favicon);

            //coppyright
            $copyright = setting::select('description')->where('code', 'copyright')->first();
            view()->share('copyright', $copyright);
            

            //email
            $email = setting::select('description')->where('code', 'email')->first();
            view()->share('email', $email); 

            //phone
            $phone = setting::select('description')->where('code', 'phone')->first();
            view()->share('pohne', $phone);

            //address
            $address = setting::select('description')->where('code', 'address')->first();
            view()->share('copyright', $address);
            
            //SocialFaceBook
            $SocialFaceBook = setting::select('description', 'link')->where('code', 'SocialFaceBook')->first();
            view()->share('copyright', $SocialFaceBook);

            //address
            $SocialYoutube = setting::select('description', 'link')->where('code', 'SocialYoutube')->first();
            view()->share('copyright', $SocialYoutube);

            //NameCompany
            $NameCompany = setting::select('description')->where('code', 'NameCompany')->first();
            view()->share('NameCompany', $NameCompany);


            return response()->json([
                'status' => 200,
                'data' =>[ 
                    "logo" =>   $logo,
                    "favicon" => $favicon,
                    "copyright" => $copyright,
                    "email" => $email,
                    "phone" => $phone,
                    "address" => $address,
                    "SocialFaceBook" => $SocialFaceBook,
                    "SocialYoutube" => $SocialYoutube,
                    "NameCompany" => $NameCompany,
                ]
            ], 200);
        } 
        catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
        
    }
}
