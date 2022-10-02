<?php

namespace App\Http\Validators\Vaccine;

use App\Http\Validators\ValidatorBase;


class InsertVaccineValidate extends ValidatorBase
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
            "code" => "required|unique:vaccines",
            'name' => "required",
            'price' => "required",
            'description' => "required",
            'sick_id' => "required",
            // 'national_id' => "required",
        ];
    }

    protected function messages()
    {
        return [
            'code.required' => 'Không được bỏ trống code',
            'code.unique'   => 'Trùng mã code',
            'name.required' => 'Không được bỏ trống name',
            'price.required' => 'Không được bỏ trống price',
            'description.required' => 'Không được bỏ trống description',
            'sick_id.required' => 'Không được bỏ trống sick_id',
            // 'national_id.required' => 'Không được bỏ trống national_id',
        ];
    }
}
