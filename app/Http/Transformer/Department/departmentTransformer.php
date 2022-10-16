<?php
namespace App\Http\Transformer\Department;

use App\Models\Department;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class departmentTransformer extends TransformerAbstract
{
    public function transform(Department $Department)
    {
        return [
            'id'   => $Department->id,
            'code' => $Department->code,
            'name' => $Department->name,
            'specialist_id' => $Department->specialist_id,
            'specialist_name' => $Department->Specialist->name,      
            'description' => $Department->description,
        ];
    }
}