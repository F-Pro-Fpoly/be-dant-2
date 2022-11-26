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
        (new InsertDoctor_profileValidate($input));
        try{
            Doctor_profile::create([
                'id_user' => auth()->user()->id,
                'namelink' => $input['namelink'],
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
    // select all ???? thiếu specialist name của transformer
    public function listDoctor_profile(Request $request){
        $input = $request->all();
        $Doctor_profile = new Doctor_profile();
        $data = $Doctor_profile->searchDoctor_profile($input);
        return $this->response->paginator($data, new Doctor_profileTransformer);
    }
    //select ID ??? thiếu specialist name của transformer
    public function Doctor_profileID(Request $request, $id){
        $input = $request->all();
        $Doctor_profile = Doctor_profile::where('doctor_profiles.id_user',$id)->first();
        $data = $Doctor_profile->searchDoctor_profile($input);
        return $this->response->paginator($data, new Doctor_profileTransformer);
        
    }
    // update Done
    public function updateDoctor_profile(Request $request, $id){
        $input = $request->all();
        //(new UpdateDoctor_profileValidate($input));
        try{
            $data = Doctor_profile::where('id_user',$id)->first();

            if($data){
                $data->update([
                    'namelink' => $input['namelink'],
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
        $Doctor_profile = Doctor_profile::select('doctor_profiles.*', 'users.name as doctor_name', 'specialists.name as specialists_name')
                        ->join('users', 'users.id', 'doctor_profiles.id_user')
                        ->join('specialists', 'specialists.id', 'users.specailist_id')
                        ->where('doctor_profiles.id_user',$id)->first();
        if($Doctor_profile){
            return response()->json([
                'status'  => 200,
                'data' => $Doctor_profile
            ],200);
        }
        else{
            return response()->json([
                'status'  => 400,
                'message' => 'Không tìm thấy thông tin bác sĩ này',
            ],400);
        }
        
        }
}
    

