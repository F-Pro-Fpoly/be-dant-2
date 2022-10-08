<?php

namespace App\Http\Validators\Specialist;

use App\Http\Validators\ValidatorBase;


class InsertSpecialistValidate extends ValidatorBase
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
            "code" => "required|unique:specialists",
            'name' => "required",
            'description' => "required",
        ];
    }

    protected function messages()
    {
        return [
            'code.required' => 'Không được bỏ trống code',
            'code.unique'   => 'Trùng mã code',
            'name.required' => 'Không được bỏ trống name',
            'description.required' => 'Không được bỏ trống description',
        ];
    }
}
