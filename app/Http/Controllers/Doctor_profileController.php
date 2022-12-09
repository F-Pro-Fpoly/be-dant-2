<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Doctor_profile\Doctor_profileTransformer;
use App\Http\Validators\Doctor_profile\InsertDoctor_profileValidate;
use App\Http\Validators\Doctor_profile\UpdateDoctor_profileValidate;
use App\Models\Doctor_profile;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Doctor_profileController extends BaseController
{
    // add Done
    public function addDoctor_profile(Request $request){
        $input = $request->all();
        try{
            Doctor_profile::create([
                'id_user' => auth()->user()->id,
                'namelink' => "fb" ,
                'link' => $input['link'],
                'context' => $input['context'],
                'level' => $input['level'],
                'introduce' => $input['introduce'],
                'experience' => $input['experience'],
                'created_by' => auth()->user()->id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Thêm thông tin thành công'
            ],200);

        } catch(Exception $th){
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }

    
        
    }
    // select all done
    public function listDoctor_profile(Request $request){
        try{
            $input = $request->all();
            $Doctor_profile = new Doctor_profile();
            $data = $Doctor_profile->searchDoctor_profile($input);
            return $this->response->paginator($data, new Doctor_profileTransformer);
        }catch(Exception $th){
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    //select ID DONE
    public function Doctor_profileID(Request $request, $id){
        try{
            $input = $request->all();
            $Doctor_profile = Doctor_profile::where('doctor_profiles.id_user',$id)->first();

           
            if($Doctor_profile) {
                return $this->response->item($Doctor_profile, new Doctor_profileTransformer);
            }else{
                return ['data' => 'none'];
            }
         
            
            
        } catch(Exception $th){
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        } 
    }

    // update Done
    public function updateDoctor_profile(Request $request, $id){
        $input = $request->all();
        //(new UpdateDoctor_profileValidate($input));
        try{
            $data = Doctor_profile::where('id_user',$id)->first();

            if($data){
                $data->update([              
                    'link' => $input['link'],
                    'context' => $input['context'],
                    'level' => $input['level'],
                    'introduce' => $input['introduce'],
                    'experience' => $input['experience'],
                    'updated_by' => auth()->user()->id
                ]);
                return response()->json([
                    'status'  => 200,
                    'message' => 'Cập nhật thông tin thành công',
                ],200);
            }
            else{
                return response()->json([
                    'status'  => 400,
                    'message' => 'Không tìm thấy thông tin bác sĩ này',
                ],400);
            }
        }
        catch (Exception $th){
            throw new HttpException(500, $th->getMessage());
        }
    }
    // delete Done
    public function deleteDoctor_profile($id){
        try {
            $data = Doctor_profile::where('id_user',$id)->first();
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa thông tin thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    // client ??? dùng get bình thường
    public function Doctor_profile_ID(Request $request, $id){
        try{
            $input = $request->all();
            $Doctor_profile = Doctor_profile::where('doctor_profiles.id_user',$id)->first();
            return $this->response->item($Doctor_profile, new Doctor_profileTransformer);
            
        } catch(Exception $th){
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }
}

