<?php

namespace App\Http\Validators\Banner;

use App\Http\Validators\ValidatorBase;


class CreateBannerValidate extends ValidatorBase
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
            'code' => 'required|unique:banners',
            'name' => 'required',
            'status' => 'required',
            'description' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            'code.required' => 'Mã banner không được bỏ trống', 
            'code.unique'   => 'Mã banner không được trùng', 
            'name.required' => 'Tên banner không được bỏ trống', 
            'status.required' => 'Trạng thái không được bỏ trống', 
            'description.required' => 'Nội dung không được bỏ trống', 
          
        ];
    }
}