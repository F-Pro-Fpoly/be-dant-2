<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\InsertUserRequest;
use App\Http\Transformer\User\UserTransformer;
use App\Http\Validators\User\InsertUserValidate;
use App\Http\Validators\User\UpdateUserValidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

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


    public function listUser(Request $request) {

        $input = $request->all();
        $user = new User();
        $data = $user->searchUser($input);
        return $this->response->paginator($data, new UserTransformer);
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
}
