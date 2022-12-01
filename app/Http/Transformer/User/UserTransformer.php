<?php
namespace App\Http\Transformer\User;

use App\Models\Schedule;
use App\Models\User;
use Dingo\Api\Http\Request;
use Dingo\Api\Transformer\Binding;
use Dingo\Api\Contract\Transformer\Adapter;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Str;
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
            "slug_name" => Str::slug($user->name),
            'email' => $user->email,
            'role_name' => $user->role->name,
            'role_id' => $user->role_id,
            'role_name' => $user->role->name,
            'active' => $user->active,
            'username' => $user->username,
            "address" => $user->address ?? null,
            "phone" => $user->phone ?? null,
            "date" => !empty($user->date) ? date_format(date_create($user->date), "Y-m-d") : null,
            'specailist_id' => $user->specailist_id ?? null,
            'specailist_name' => $user->specialist->name ?? null,
            'department_id' => $user->department_id ?? null,
            'department_name' => $user->department->name ??null,
            "gender" => $user->gender ?? null,
            "avatar" =>  strstr($user->avatar, "http") != false  ? $user->avatar :(env('APP_URL', 'http://localhost:8080').$user->avatar),
            "thumbnail_name" => $user->avatar,
            "user_info" => $user->user_info ?? null,
            'city_code' => $user->city_code,
            'city_name' => $user->city->name ?? null,
            'city_full_name'=> $user->city->full_name ?? null,
            'district_code' => $user->district_code,
            'district_name' => $user->district->name ?? null,
            'district_full_name' => $user->district->full_name ?? null,
            'ward_code' => $user->ward_code,
            'ward_name' => $user->ward->name ?? null,
            'ward_full_name' => $user->ward->full_name ?? null,
            'birthday' => $user->birthday ?? null
        ];
        // dd($this->is_add_data_doctor);
        if($this->is_add_data_doctor) {
            $schudule_data = $user->get_data_schudule([
                'date' => $this->input['schedule_date']??null,
                'interval' => $this->input['interval']??null
            ]);
            $data = array_merge($data, $schudule_data);
        }
        return $data;
    }
}