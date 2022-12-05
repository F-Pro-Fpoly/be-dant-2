<?php

namespace App\Http\Validators\News_category;

use App\Http\Validators\ValidatorBase;

    
class UpdateNews_categoryValidate extends ValidatorBase
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
<<<<<<< HEAD
            'code' => 'required|min:5|max:255|unique:news',
            'slug' => 'required|unique:news',
            'status' => 'required',
            'name' => 'required|min:5|max:255',
=======
            "code" => "required|min:5|max:255",
            "slug" => "required",
            "status" => "required",
            "name" => "required|min:5|max:255",
>>>>>>> 7c5f6f0c42e03b2264d044079273dba62ab42e85
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
