<?php

namespace App\Http\Validators\Booking;

use App\Http\Validators\ValidatorBase;


class UpdateBookingValidate extends ValidatorBase
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
            "code" => "min:5|max:255|unique:bookings",
        ];
    }

    protected function messages()
    {
        return [
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
            'code.unique'   => 'Trùng mã code',
        ];
    }
}
