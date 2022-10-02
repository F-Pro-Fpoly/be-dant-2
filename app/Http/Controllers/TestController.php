<?php

namespace App\Http\Controllers;

use App\Http\Transformer\User\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use Carbon\Carbon;

class TestController extends BaseController
{
    protected $role;
    protected $user;

    function __construct()
    {
        $this->role = new Role();
        $this->user = new User();
    }


    public function show($id)
	{
		$user = User::findOrFail($id);

		return $this->response->item($user, new UserTransformer());
	}

    public function listUser(){
        $users = User::with(['role'])->paginate(10);

		return $this->response->paginator($users, new UserTransformer());
    }

    public function addImg(Request $request) {
        // Storage::disk('local')->put('avatars/1', $request->file('img'));
        // Storage::disk('local')->put('example.txt', 'Contents');
        $date = Carbon::now()->format('Ymds');
        $name = $request->file('image')->store('images','public');
        dd($name);
    }

    public function testSearch(Request $request){
        $input = $request->all();

        $inputArr = [];

        foreach($input as $key => $val){
            $item = [$key, '=', $val];
            array_push($inputArr, $item);
        }
        $data = $this->user->searchUser($inputArr);

        dd($data);
    }
}
