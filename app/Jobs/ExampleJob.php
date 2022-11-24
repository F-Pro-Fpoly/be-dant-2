<?php

namespace App\Jobs;

use App\Models\Newsletter;
use App\Models\News;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExampleJob extends Job
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $title_mail = "Tin sốt dẻo";
        $data = [];
        $dataNewsletter = Newsletter::all();
        $dataNews = News::where('status', 1)->orderBy('created_at', 'DESC')->first();
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
    }
}
