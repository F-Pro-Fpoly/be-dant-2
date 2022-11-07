<?php

namespace App\Http\Validators\News_category;

use App\Http\Validators\ValidatorBase;


class InsertNews_categoryValidate extends ValidatorBase
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
            "code" => "required|min:5|max:255|unique:news",
        ];
    }

    protected function messages()
    {
        return [
            'code.required' => 'Không được bỏ trống code',
            'code.unique'   => 'Trùng mã code',
            'slug.required' => 'Không được bỏ trống slug',
            'status.required' => 'Không được bỏ trống status',
            'name.required' => 'Không được bỏ trống name',
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
        ];
    }
}
