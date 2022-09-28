<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:8|max:255',
            'username' => 'required|min:8|max:255|unique:users',
            'email' => 'required|min:8|max:255|unique:users|email',
            'password' => 'required|min:8|max:255',
            // 'address' => 'required|min:5|max:255',
            // 'phone' => 'required|min:10|max:10',
        ],[
            //name
            'name.required' => 'Họ và tên không được bỏ trống', 
            'name.min' => 'Họ và tên quá ngắn!(Tối thiểu 8 ký tự)',
            'name.max' => 'Họ và tên quá dài!(Tối đa 255 ký tự)',
            // username
            'username.required' => 'Username không được bỏ trống', 
            'username.min' => 'Username quá ngắn!(Tối thiểu 8 ký tự)',
            'username.max' => 'Username quá dài!(Tối đa 255 ký tự)',
            'username.unique' => 'Username đã tồn tại!(Sử dụng một Username khác)',
            // email
            'email.required' => 'Email không được bỏ trống', 
            'email.min' => 'Email quá ngắn!(Tối thiểu 8 ký tự)',
            'email.max' => 'Email quá dài!(Tối đa 255 ký tự)',
            'email.unique' => 'Email đã tồn tại!(Sử dụng một Email khác)',
            'email.email' => 'Email chưa đúng định dạng(Kiểm tra lại Email)',
            // password
            'password.required' => 'Mật khẩu không được bỏ trống', 
            'password.min' => 'Mật khẩu quá ngắn!(Tối thiểu 8 ký tự)',
            'password.max' => 'Mật khẩu quá dài!(Tối đa 255 ký tự)',
            // // address
            // 'address.required' => 'Địa chỉ không được bỏ trống', 
            // 'address.min' => 'Địa chỉ quá ngắn!(Tối thiểu 5 ký tự)',
            // 'address.max' => 'Địa chỉ quá dài!(Tối đa 255 ký tự)',
            // // phone
            // 'phone.required' => 'Số điện thoại không được bỏ trống', 
            // 'phone.min' => 'Số điện thoại quá ngắn!(Tối thiểu 10 ký tự)',
            // 'phone.max' => 'Số điện thoại quá dài!(Tối đa 10 ký tự)',
        ]);

        if($validator->fails()) {
            $arrRes = [
                'errCode' => 1,
                'message' => "Lỗi validate dữ liệu",
                'data' => $validator->errors()
            ];

            return response()->json($arrRes, 402);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password'=> Hash::make($request->password),
                'address' => $request->address,
                'phone' => $request->phone,
                'role_id' => 3,
                'active' => 1,
                'avatar' => 'https://cdn-icons-png.flaticon.com/512/219/219983.png'
            ]);

            $arrRes = [
                'errCode' => 0,
                'message' => "Đăng ký thành công",
                'data' => []
            ];
        } catch (\Throwable $th) {
            $arrRes = [
                'errCode' => 0,
                'message' => "Lỗi phía server",
                'data' => $th->getMessage()
            ];

            $status = 500;
        }
        return response()->json($arrRes, $status ?? 201);
    }


    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email'=> 'email|required|min:8',
            'password' => 'required|min:8'
        ]);


        if($validator->fails()) {
            $arrRes = [
                'errCode'=> 1,
                'message' => 'Lỗi validate dữ liệu',
                'data' => $validator->errors()
            ];

            return response()->json($arrRes, 402);
        }


        try {
            if(!$token = auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                $arrRes = [
                    'errCode'=> 2,
                    'message' => 'Vui lòng kiểm tra email và mật khẩu',
                    'data' => []
                ];
                return response()->json($arrRes, 201);
            }


            // auth()->login($token);
            $arrRes = [
                'errCode'=> 0,
                'message' => 'Đăng nhập thành công',
                'data' => [
                    "user" => auth()->setToken($token)->user(),
                    'token' => $token
                ]
            ];
            return response()->json($arrRes, 201);
        } catch (\Throwable $th) {
            $arrRes = [
                'errCode'=> 2,
                'message' => 'Lỗi phía server',
                'data' => $th->getMessage()
            ];
            return response()->json($arrRes, 501);
        }

    }
}
