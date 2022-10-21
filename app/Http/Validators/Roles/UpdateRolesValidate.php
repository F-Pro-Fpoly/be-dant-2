<?php

namespace App\Http\Validators\Roles;

use App\Http\Validators\ValidatorBase;


class UpdateRolesValidate extends ValidatorBase
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
            'name' => 'min:5|max:255',
            'code' => 'min:5|max:255|unique:roles'
        ];
    }

    protected function messages()
    {
        return [
            //name
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
            //code
            'code.min' => 'Code quá ngắn!(Tối thiểu 5 ký tự)',
            'code.max' => 'Code quá dài!(Tối đa 255 ký tự)',
            'code.unique' => 'Code đã tồn tại!(Sử dụng một Code khác)'
        ];
    }
}
