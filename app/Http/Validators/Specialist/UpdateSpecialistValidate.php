<?php

namespace App\Http\Validators\Specialist;

use App\Http\Validators\ValidatorBase;


class UpdateSpecialistValidate extends ValidatorBase
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
            'slug' => 'required|min:5|max:255',
            'name' => 'required|min:5|max:255',
            'description' => 'required|min:8|max:255',
        ];
    }

    protected function messages()
    {
        return [
             //slug
             'slug.required' => 'Slug không được bỏ trống', 
             'slug.min' => 'Slug quá ngắn!(Tối thiểu 5 ký tự)',
             'slug.max' => 'Slug quá dài!(Tối đa 255 ký tự)',
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
