<?php
namespace App\Http\Transformer\User;

use App\Models\Schedule;
use App\Models\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $is_add_data_doctor = false;
    protected $input = [];
    public function __construct(bool $is_add_data_doctor = false, array $input = [])
    {
        $this->is_add_data_doctor = $is_add_data_doctor;
        $this->input = $input;
    }
    public function transform(User $user)
    {
        $data = [
            "id" => $user->id,
            'name'=> $user->name,
            'email' => $user->email,
            'role_name' => $user->role->name,
            'role_id' => $user->role_id,
            'role_name' => $user->role->name,
            'active' => $user->active,
            'username' => $user->username,
            "address" => $user->address ?? null,
            "phone" => $user->phone ?? null,
            "date" => !empty($user->date) ? date_format(date_create($user->date), "d/m/Y") : null,
            'specailist_id' => $user->specailist_id ?? null,
            'specailist_name' => $user->specialist->name ?? null,
            'department_id' => $user->department_id ?? null,
            'department_name' => $user->department->name ??null,
            "gender" => $user->gender ?? null,
            "avatar" =>  strstr($user->avatar, "http") != false  ? $user->avatar :(env('APP_URL', 'http://localhost:8080').$user->avatar),
            "user_info" => $user->user_info ?? null
        ];
        // dd($this->is_add_data_doctor);
        if($this->is_add_data_doctor) {
            $schudule_data = $user->get_data_schudule([
                'date' => $this->input['schedule_date']??null
            ]);
            $data = array_merge($data, $schudule_data);
        }
        return $data;
    }
}