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
            'code' => 'min:5|max:255',
            'name' => 'min:5|max:255',
            'description' => 'min:8|max:255',
        ];
    }

    protected function messages()
    {
        return [
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)',
            //Name
            'name.min' => 'Name quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Name quá dài!(Tối đa 255 ký tự)',
            //description
            'description.min' => 'Description quá ngắn!(Tối thiểu 5 ký tự)',
            'description.max' => 'Description quá dài!(Tối đa 255 ký tự)',
        ];
    }
}
