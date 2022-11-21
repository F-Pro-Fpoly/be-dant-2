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
            "name" => "required",
            "email" => "required",
            "contents" => "required",
            "type" => "required",
            "phone" => "required",
            



        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'Không được bỏ trống name',
            'email.required' => 'Không được bỏ trống email',
            'contents.required' => 'Không được bỏ trống contents',
            'type.required' => 'Không được bỏ trống type',
            'phone.required' => 'Không được bỏ trống phone',

    
        
        ];
    }
}
