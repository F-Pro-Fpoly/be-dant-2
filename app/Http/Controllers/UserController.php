<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\InsertUserRequest;
use App\Http\Validators\User\InsertUserValidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    public function addUser(Request $request) {
        $input = $request->all();
        (new InsertUserValidate($input));
    }

    public function listUser() {

    }
}
