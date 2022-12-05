<?php

namespace App\Http\Validators\Booking;

use App\Http\Validators\ValidatorBase;


class CreateBookingNoAuthValidate extends ValidatorBase
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
            'address' => 'required',
            'city_code' => 'required',
            'customer_name'=> 'required',
            'phone' => 'required',
            'birthday' => "required",
            'district_code' => 'required',
            'ward_code' => 'required'
        ];
    }

    protected function messages()
    {
        return [];
    }
}