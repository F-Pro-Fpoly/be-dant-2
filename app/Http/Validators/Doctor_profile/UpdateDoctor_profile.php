<?php

namespace App\Http\Validators\Doctor_profile;

use App\Http\Validators\ValidatorBase;


class UpdateDoctor_profileValidate extends ValidatorBase
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
            //"namelink" => => "required",
            //"link" => "required",
            "context" => "required",
            "level" => "required",
            //"introduce" => "required",
            "experience" => "required",
        ];
    }

    protected function messages()
    {
        return [
            'link.required' => 'Không được bỏ trống link',
            'namelink.required' => 'Không được bỏ trống namelink',
            'context.required' => 'Không được bỏ trống thông tin',
            'level.required' => 'Không được bỏ trống trình độ',
            'introduce.required' => 'Không được bỏ trống giới thiệu',
            'experience.required' => 'Không được bỏ trống kinh nghiệm',
        ];
    }
}
