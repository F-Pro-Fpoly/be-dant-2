<?php

namespace App\Http\Validators\User;

use App\Http\Validators\ValidatorBase;


class InsertUserValidate extends ValidatorBase
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
            "username" => "required|unique:users|min:6",
            'email' => "required|unique:users|min:6",
            'name' => "required|min:6",
            'password' => "required|min:6",
        ];
    }

    protected function messages()
    {
        return [];
    }
}
