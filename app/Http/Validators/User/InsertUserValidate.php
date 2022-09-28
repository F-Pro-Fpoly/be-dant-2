<?php

namespace App\Http\Validators\User;

use App\Http\Validators\ValidatorBase;


class InsertUserValidate extends ValidatorBase
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            "username" => "required|unique:users|min:6"
        ];
    }

    protected function messages()
    {
        return [];
    }
}
