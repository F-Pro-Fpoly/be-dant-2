<?php
namespace App\Http\Transformer\Department;

use App\Models\Department;
use App\Models\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class departmentTransformer extends TransformerAbstract
{
    public function transform(Department $Department)
    {
        $users = User::where('role_id', 2)->where('department_id', $Department->id)->get();

        $docters = [];

        foreach($users as $item) {
            $docters [] = [
                'name' => $item->name,
                'id' => $item->id,
                'username' => $item->username,
                'active' => $item->active,
                'role_name' => $item->role->name,
                'role_id' => $item->role_id
            ];
        }

        return [
            'id'   => $Department->id,
            'code' => $Department->code,
            'name' => $Department->name,
            'specialist_id' => $Department->specialist_id,
            'specialist_name' => $Department->Specialist->name,      
            'description' => $Department->description,
            'active' => $Department->active,
            'update_by_name' => $Department->user->name ?? null,
            'docters' => $docters
        ];
    }
}