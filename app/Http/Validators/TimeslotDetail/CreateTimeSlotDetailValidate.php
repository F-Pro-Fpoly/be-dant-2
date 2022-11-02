<?php

namespace App\Http\Validators\TimeslotDetail;

use App\Http\Validators\ValidatorBase;


class CreateTimeSlotDetailValidate extends ValidatorBase
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
            "schedule_id" => "required",
            "timeslot_id" => "required",
            "status_id" => "required",
            "status_code" => "required"
        ];
    }

    protected function messages()
    {
        return [];
    }
}
