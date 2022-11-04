<?php

namespace App\Http\Validators\User;

use App\Http\Validators\ValidatorBase;


class UpdateUserValidate extends ValidatorBase
{

    public function __construct($input)
    {
        parent::__construct($input);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            // 'name' => "required|min:6",
            // 'role_id' => 'required',
            // 'active' => 'required'
        ];
    }

    protected function messages()
    {
        return [
            // "role_id.required" => "Chọn phân quyền"
        ];
    }
}
