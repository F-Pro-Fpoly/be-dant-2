<?php

namespace App\Http\Validators\page;

use App\Http\Validators\ValidatorBase;


class UpdatePageValidate extends ValidatorBase
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
            'name' => 'required|unique:pages',
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Tên trang không được bỏ trống', 
            'name.unique'   => 'Tên trang không được trùng', 
        ];
    }
}
