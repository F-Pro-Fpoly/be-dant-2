<?php
namespace App\Http\Transformer\Role;

use App\Models\Role;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public function transform(Role $role)
    {
        return [
            "id" => $role->id,
            'code'=> $role->code,
            'name' => $role->name,
        ];
    }
}