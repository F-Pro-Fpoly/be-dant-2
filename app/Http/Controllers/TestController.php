<?php

namespace App\Http\Controllers;

use App\Http\Transformer\User\UserTransformer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends BaseController
{
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


    }
}
