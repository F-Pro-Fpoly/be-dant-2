<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\InsertUserRequest;
use App\Http\Transformer\Booking\BookingTransformer;
use App\Http\Transformer\User\UserTransformer;
use App\Http\Validators\User\InsertUserValidate;
use App\Http\Validators\User\UpdateUserValidate;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Supports\TM_Error;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class UserController extends BaseController
{
    public function addUser(Request $request) {
        $input = $request->all();
        (new InsertUserValidate($input));

        try {
            User::create([
                "username" => $input['username'],
                'password' => Hash::make($input['password']),
                'email' => $input['email'],
                'name' => $input['name'],
                'active' => $input['active'] ?? 1,
                'avatar' => 'https://cdn-icons-png.flaticon.com/512/219/219983.png',
                'role_id' => $input['role_id'] ?? 3,
            ]);

            return response()->json([
                "message" => "Thêm người dùng thành công",
                "status" => 201
            ],201);
        } catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    public function getUser($id, Request $request){
        $input = $request->all();
        try {
            $user = User::findOrFail($id);

            return $this->response->item($user, new UserTransformer());
        } catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    public function getUserClient(Request $request) {
        $input = $request->all();
        $id = auth()->user()->id ?? null;

        try {
            $user = User::findOrFail($id);
            return $this->response->item($user, new UserTransformer());
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }


    public function listUser(Request $request) {
        $input = $request->all();
        try {
            $user = new User();
            $data = $user->searchUser($input);
            if(!empty($input['add_time_slot'])) {
                return $this->response->paginator($data, new UserTransformer(true, $input));
            }
            return $this->response->paginator($data, new UserTransformer());
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function listUserV2(Request $request) {
        $input = $request->all();
        try {
            $user = new User();
            $data = $user->searchUserV2($input);
            if(empty($input['limit'])){
                return $this->response->collection($data, new UserTransformer());
            }
            return $this->response->paginator($data, new UserTransformer());
        } catch (\Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    function deleteUser($id){
        try {
            $data = User::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa khách hàng thành công"
        ], 200);
        } catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
       }
    }

    public function update($id, Request $request) {
        $input = $request->all();
        (new UpdateUserValidate($input));    
        try {
            
            $user = User::findOrFail($id);

            if(!empty($input['avatar'])) {
                $file = $request->file('avatar')->store('images','public');              
                $user->avatar =  $file;
                $user->save();     
            }
    
            $user->updateUser($input);

            return response()->json([
                'message' => "Cập nhập người dùng thành công",
                'status' => 201
            ], 201);
        } catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
    public function updateByName(Request $request) {
        $input = $request->all();
        // (new UpdateUserValidate($input));
        if(!empty($input['username'])) {
            $id = User::where("username", "like", "%{$input['username']}%")->value('id');
        }
        try {
            // dd($id);
            $user = User::findOrFail($id);

            $user->updateUser($input);

            return response()->json([
                'message' => "Cập nhập người dùng thành công",
                'status' => 201
            ], 201);
        } catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function updatePassword($id,Request $request) {
        $input = $request->all();
        try {

            $user = User::findOrFail($id);
            
            $current_password = auth()->User()->password;           
            if(Hash::check($input['old_pass'], $current_password)){

                if($input['new_pass'] == $input['comfirm_pass']){
                    $user->update([
                        'password' =>  Hash::make($input['new_pass']),
                        'updated_by' => auth()->user()->id,            
                    ]);
                    return response()->json([
                        'message' => "Cập nhập người dùng thành công",
                        'status' => 201
                    ], 201);
                }else{
                    return response()->json([
                        'message' => "Mật khẩu không trùng nhau!",
                        'status' => 401
                    ], 401);
                }
               
            }else{
                return response()->json([
                    'message' => "Sai mật khẩu vui lòng kiểm tra lại!",
                    'status' => 401
                ], 401);
            }

           
           
        } catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }


    public function forgetPassword(Request $request) {
        $input = $request->all();
        try {
            $user = User::where('email', $input['email'])->first();
            if($user){

                Mail::send('email.forgetPass', compact('user'), function ($email) use ($user) {
                    $email->subject('FPRO - THAY ĐỔI MẬT KHẨU');
                    $email->to($user->email);            
                });      
                
            }
            else{
                throw new HttpException(400, "Không tồn tại email ".$input['email']." trong hệ thống");
            }       
           
        } catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function ChangePass(Request $request, $id)
    {
        $input = $request->all();
        try {
            $user = User::find($id);
            if($input['new_pass'] == $input['comfirm_pass']){
                $user->update([
                    'password' =>  Hash::make($input['new_pass']),
                    'updated_by' => $user->id,            
                ]);
                return response()->json([
                    'message' => "Cập nhập người dùng thành công",
                    'status' => 201
                ], 201);
            }else{
                return response()->json([
                    'message' => "Mật khẩu không trùng nhau!",
                    'status' => 401
                ], 401);
            }
        } catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }


    public function getInfo(Request $request){
        $input = $request->all();
        $id = auth()->user()->id;
        try {
            $user = User::findOrFail($id);
            return $this->response->item($user, new UserTransformer());
        } catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    public function profileDoctor(Request $request,  $id)
    {      
        $input = $request->all();
        try {
            $user = User::findOrFail($id);
            return $this->response->item($user, new UserTransformer());
        } catch (Exception $th) {
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }

    public function updateClient(Request $request) {
        $input = $request->all();
        // (new UpdateUserValidate($input));
        // if(!empty($input['username'])) {
        //     $id = User::where("username", "like", "%{$input['username']}%")->value('id');
        // }
        try {
            // dd($id);
            $id = auth()->user()->id ?? null;
            $user = User::findOrFail($id);

            $user->updateUser($input);

            return response()->json([
                'message' => "Cập nhập người dùng thành công",
                'status' => 201
            ], 201);
        } catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }

    public function listPatient(Request $request){
        $input = $request->all();
        try {    
            $user = new User();
            $data = $user->searchListPatient($input);
            return $this->response->paginator($data, new UserTransformer);
        } catch (\Exception $th) {
             $ex_handle = new TM_Error($th);
             return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
     }
    public function listPatientDetail(Request $request){
        $input = $request->all();
        try {        
            // $booking =  Booking::where('user_id', $id)->get();
            $booking = (new Booking())->searchBookingPariend($input);
            return $this->response->paginator($booking, new BookingTransformer);
        } catch (\Exception $th) {
             $ex_handle = new TM_Error($th);
             return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }
    }

    public function exportPDFMedicalRecord(Request $request, $id) {
        $input = $request->all();

        try {
            $user = User::findOrFail($id);
            $booking = Booking::model()->where('user_id', $id)-> where('is_vaccine', 0)->get();
            $booking_vaccine = Booking::model()->where('user_id', $id) -> where('is_vaccine', 1)->get();
            $pdf = Pdf::loadView('pdf.medical_record', [
                'user' => $user,
                'bookings' => $booking,
                'booking_vaccines' => $booking_vaccine
            ]);
            return $pdf->download('ho_so_benh_an.pdf');
        } catch (\Exception $ex) {
            $ex_handle = new TM_Error($ex);
            return $this->response->error($ex_handle->getMessage(), $ex_handle->getStatusCode());
        }

    }

}
