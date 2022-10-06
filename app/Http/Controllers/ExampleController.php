<?php

namespace App\Http\Controllers;

use Dingo\Api\Http\Request as HttpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request) {
        $input = $request->all();
        $name = Arr::get($input, 'name', null);
        return response()->json(['name' => $name], 200);
    }
}
