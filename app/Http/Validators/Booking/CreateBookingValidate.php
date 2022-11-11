<?php

namespace App\Http\Validators\Booking;

use App\Http\Validators\ValidatorBase;


class CreateBookingValidate extends ValidatorBase
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
            'doctor_id' => 'required',
            'payment_method' => 'required',
            'price' => 'required',
        ];
    }

    protected function messages()
    {
        return [];
    }
}