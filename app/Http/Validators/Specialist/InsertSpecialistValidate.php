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
            'code' => 'required|min:5|max:255|unique:specialists',
            'name' => 'required|min:5|max:255',
            'description' => 'required|min:8',
            'file' => 'required|file' 
        ];
    }

    protected function messages()
    {
        return [
             //code
             'code.required' => 'Code không được bỏ trống', 
             'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
             'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
             'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
             //Name
             'name.required' => 'Name không được bỏ trống', 
             'name.min' => 'Name quá ngắn!(Tối thiểu 5 ký tự)',
             'name.max' => 'Name quá dài!(Tối đa 255 ký tự)',
             //description
             'description.required' => 'Description không được bỏ trống', 
             'description.min' => 'Description quá ngắn!(Tối thiểu 5 ký tự)',
             'description.max' => 'Description quá dài!(Tối đa 255 ký tự)',
        ];
    }
}
