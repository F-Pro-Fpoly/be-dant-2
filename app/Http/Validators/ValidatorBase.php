<?php
namespace App\Http\Validators;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Facades\Validator;

abstract class ValidatorBase {
    private $input;

    public function __construct($input = [])
    {   
        $this->input = $input;
        $this->validate($this->input); 
    }


    abstract protected function rules();

    abstract protected function messages();

    public function validate($input) {
        $this->input = $input;

        $validator = Validator::make($input, $this->rules(), $this->messages());
        if ($validator->fails()) {
            throw new StoreResourceFailedException("Lỗi validate dữ liệu",$validator->errors()->getMessages());
        }

        return $validator;
    }
}
?>