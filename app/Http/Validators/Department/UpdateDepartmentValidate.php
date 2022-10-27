<?php

namespace App\Http\Validators\Department;

use App\Http\Validators\ValidatorBase;


class UpdateDepartmentValidate extends ValidatorBase
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
            'code' => 'required',
            // 'name' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Tên phòng ban không được bỏ trống', 
            'code.required' => 'Code phòng ban không được bỏ trống', 
        ];
    }
}
