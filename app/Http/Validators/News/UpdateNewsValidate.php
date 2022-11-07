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
            'code.required' => 'Không được bỏ trống code',
            'code.unique'   => 'Trùng mã code',
            'slug.required' => 'Không được bỏ trống slug',
            'featured.required' => 'Không được bỏ trống featured',
            'status.required' => 'Không được bỏ trống status',
            'category_id.required' => 'Không được bỏ trống category_id',
            'name.required' => 'Không được bỏ trống name',
            'name.min' => 'Tên quá ngắn!(Tối thiểu 5 ký tự)',
            'name.max' => 'Tên quá dài!(Tối đa 255 ký tự)',
            'file.required' => 'Không được bỏ trống code',
            'content.required' => 'Không được bỏ trống code', 
        ];
    }
}
