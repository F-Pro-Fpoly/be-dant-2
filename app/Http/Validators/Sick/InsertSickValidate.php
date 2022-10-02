<?php

namespace App\Http\Validators\Sick;

use App\Http\Validators\ValidatorBase;


class InsertSickValidate extends ValidatorBase
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
            "code" => "required|unique:sicks",
            'name' => "required",
        ];
    }

    protected function messages()
    {
        return [
            'code.required' => 'Không được bỏ trống code',
            'code.unique'   => 'Trùng mã code',
            'name.required' => 'Không được bỏ trống name',
        ];
    }
}
