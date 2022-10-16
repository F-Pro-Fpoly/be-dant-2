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
            'email' => "required|min:6|email",
            'name' => "required|min:6",
            'password' => "required|min:6",
            'role_id' => 'required',
            'active' => 'required'
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => "Email không được bỏ trống",
            "email.min" => "Email quá ngắn",
            'email.email' => "Email không đúng định dạng",
            "password.required" => "Password không được bỏ trống",
            "password.min" => "Password quá ngắn",
            "role_id.required" => "Chọn phân quyền"
        ];
    }
}
