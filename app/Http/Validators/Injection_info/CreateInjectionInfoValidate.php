<?php
namespace App\Http\Validators\Injection_info;
use App\Http\Validators\ValidatorBase;

class CreateInjectionInfoValidate extends ValidatorBase
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
            'type'=> 'required',
            'time_apointment' => 'required',
            'type_name' => 'required',
            // 'status_code' => 'required',
            'booking_id' => 'required',
        ];
    }

    protected function messages()
    {
        return [
            
        ];
    }
}