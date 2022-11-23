<?php

namespace App\Http\Validators\Newsletter;

use App\Http\Validators\ValidatorBase;


class InsertNewsletterValidate extends ValidatorBase
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
            'email' => "required|unique:newsletters",
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => 'Không được bỏ trống email', 
            'email.unique' => 'Email đã được sử dụng!!!', 
        ];
    }
}
