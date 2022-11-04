<?php
namespace App\Http\Transformer\User;

use App\Models\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            "id" => $user->id,
            'name'=> $user->name,
            'email' => $user->email,
            'role_name' => $user->role->name,
            'role_id' => $user->role_id,
            'active' => $user->active,
            'username' => $user->username,
            "address" => $user->address ?? null,
            "phone" => $user->phone ?? null,
            "date" =>   $user->date,
            "gender" => $user->gender ?? null,
            "avatar" =>  strstr($user->avatar, "http") != false  ? $user->avatar :(env('APP_URL', 'http://localhost:8080').$user->avatar)
        ];
    }
}