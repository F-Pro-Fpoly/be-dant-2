<?php

namespace App\Http\Controllers;

use App\Http\Transformer\Newsletter\NewsletterTransformer;
use App\Http\Validators\Newsletter\InsertNewsletterValidate;
use App\Models\Newsletter;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\OrderShipped;
use App\Supports\TM_Error;

use App\Jobs\SendNewsletter;

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
    
    public function listNewsletter(Request $request){
        $input = $request->all();
        $News = new Newsletter();
        $data = $News->searchNewsletter($input);
        return $this->response->paginator($data, new NewsletterTransformer);
    }
    
    public function sendNewsletter(){
        try {
            // $Newsletter = Newsletter::all();
            // $job = (new SendNewsletter($Newsletter));
            // dispatch($job);

            $dataNewsletter = Newsletter::all();
            $dataNews = News::where('status', 1)->orderBy('created_at', 'DESC')->first();
            $title_mail = "Tin sốt dẻo";

            foreach($dataNewsletter as $send){
                $data['email'][] = $send->email;
            }
            Mail::send('email.Newsletter', compact('dataNews'), function ($messager) use ($title_mail, $data){
                $messager->to($data['email'])->subject($title_mail);
                $messager->from($data['email'], $title_mail);
            });

            return response()->json([
                "message" => "Gửi mail thành công"
            ], 200);
            
        } catch (\Exception $th) {
            $res = new TM_Error($th);
            return $this->response->error($res->getMessage(), $res->getStatusCode());
        }
    }
}
