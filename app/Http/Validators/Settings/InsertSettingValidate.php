<?php

namespace App\Http\Validators\Settings;

use App\Http\Validators\ValidatorBase;


class InsertSettingValidate extends ValidatorBase
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
            'code' => 'required|unique:settings',
            'status' => 'required',
            'description' => 'required',
        ];
    }

    protected function messages()
    {
        return [
             'code.required' => 'Tên cofig không được bỏ trống', 
             'status.required' => 'Trạng thái không được bỏ trống', 
             'description.required' => 'Nội dung không được bỏ trống', 
             'code.unique'   => 'Tên cofig không được trùng', 

        ];
    }
}
