<?php
namespace App\Http\Transformer\Doctor_profile;

use App\Models\Doctor_profile;

use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class Doctor_profileTransformer extends TransformerAbstract
{
    public function transform(Doctor_profile $doctor_profile)
    {
        return [
            'id_user'   => $doctor_profile->id_user,
            'namelink' => $doctor_profile->namelink,
            'link' => $doctor_profile->link,
            'context' => $doctor_profile->context,
            'level' => $doctor_profile->level,
            'introduce' => $doctor_profile->introduce,
            'experience' => $doctor_profile->experience,
            'created_at' => $doctor_profile->created_at->format('d-m-Y'),
            'doctor_name' => $doctor_profile->user->name,
            'doctor_avatar' => $doctor_profile->user->avatar,
            'specialists_name' => $doctor_profile->user->specialist->name ?? null
        ];
    }
}