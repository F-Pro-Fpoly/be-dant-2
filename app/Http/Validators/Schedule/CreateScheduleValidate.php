<?php

namespace App\Http\Validators\Schedule;

use App\Http\Validators\ValidatorBase;


class CreateScheduleValidate extends ValidatorBase
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
            "date" => "required",
            "department_id" => "required"
        ];
    }

    protected function messages()
    {
        return [];
    }
}
