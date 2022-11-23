<?php

namespace App\Http\Controllers;

use App\Http\Validators\Newsletter\InsertNewsletterValidate;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsLetterController extends BaseController
{
    public function add_Newsletter(Request $request){
        $input = $request->all();
        (new InsertNewsletterValidate($input));
        try{
            Newsletter::create([
                'email' => $input['email'],
                // 'created_at' => auth()->user()->id ?? null,
            ]);

            return response()->json([
                'status' => 200,
                'message' => "Đã thêm thành công"
            ],200);
        }
        catch(\Throwable $th){
            return response()->json(
                [
                    'status' => 500,
                    'message' => $th->getMessage()
                ],500
                );
        }
    }
}
