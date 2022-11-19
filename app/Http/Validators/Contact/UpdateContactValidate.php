<?php

namespace App\Http\Validators\Contact;

use App\Http\Validators\ValidatorBase;

    
class UpdateContactValidate extends ValidatorBase
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
            'name' => 'required|min:5|max:255',
            'email' => 'required',
            'contents' => 'required',
            'type' => 'required',
            // 'phone' => 'required|min:10|max:11',

        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Không được bỏ trống name',
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
            'email.required' => 'Không được bỏ trống email',
            'contents.required' => 'Không được bỏ trống contents',
            'type.required' => 'Không được bỏ trống type',
            // 'phone.required' => 'Không được bỏ trống phone',
            // 'phone.min' => 'Số điện thoại quá ngắn!(Tối thiểu 10 ký tự)',
            // 'phone.max' => 'Số điện thoại quá dài!(Tối đa 11 ký tự)',
        
        ];
    }
}
