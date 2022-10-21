<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Role\RoleTransformer;
use App\Http\Validators\Roles\InsertRolesValidate;
use App\Http\Validators\Roles\UpdateRolesValidate;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class RoleController extends BaseController
{
       // add
    public function addRoles(Request $request){
        $input = $request->all();
        (new InsertRolesValidate($input));

        try{
            Role::create([
                'name' => $input['name'],
                'code' => $input['code'],
                'created_by' => auth()->user()->id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Thêm Roles thành công'
            ],200);
        } catch(Exception $th){
            $errors = $th->getMessage();
            throw new HttpException(500, $errors);
        }
    }
    // select all
    public function listRoleAll(Request $request){
        $input = $request->all();

        $role = new Role();
        if(!empty($input['get'])){
            if($input['get'] == 'all'){
                $role = $role->all();
                return response()->json([
                    'data' => $role
                ],200);
            }
        }
        $data = $role->searchRole($input);
        return $this->response()->paginator($data, new RoleTransformer);
    }
    //select ID
    public function listRoles_ID(Request $request, $id){
        $input = $request->all();
        $role = Role::find($id);
        if($role){
            $data = $role->searchRole($input);
            return $this->response()->paginator($data, new RoleTransformer);
        }
        else{
            return response()->json([
                'status'  => 400,
                'message' => 'Không tìm thấy Role',
            ],400);
        }
        
        }
    // update
    public function updateRoles(Request $request, $id){
        $input = $request->all();
        (new UpdateRolesValidate($input));
        
        try{
            $data = Role::find($id);
            if($data){
                $data->update([
                    'code' => $input['code'] ?? $data->code,
                    'name' => $input['name'] ?? $data->name,
                    'updated_by' => auth()->user()->id
                ]);
                return response()->json([
                    'status'  => 200,
                    'message' => 'Cập nhật Role thành công',
                ],200);
            }
            else{
                return response()->json([
                    'status'  => 400,
                    'message' => 'Không tìm thấy Role',
                ],400);
            }
        }
        catch (Exception $th){
            throw new HttpException(500, $th->getMessage());
        }
    }
    // delete
    public function deleteRoles($id){
        try {
            $data = Role::find($id);
            $data->delete();
            return response()->json([
                'status' => 200,
                'message' => "Xóa Role thành công"
        ], 200);
        } 
        catch (Exception $th) {
            throw new HttpException(500, $th->getMessage());
        }
    }
}
    

