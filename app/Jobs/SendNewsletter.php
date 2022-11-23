<?php

namespace App\Jobs;

use App\AudioProcessor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


use App\Mail\OrderShipped;
use App\Supports\TM_Error;
use App\Models\Newsletter;
use App\Models\News;
use Illuminate\Support\Facades\Mail;

class SendNewsletter extends Job
{
    use InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $Newsletter;

    public function __construct(Newsletter $Newsletter)
    {
        $this->Newsletter = $Newsletter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
            // $dataNewsletter = Newsletter::all();
            // $dataNews = News::where('status', 1)->orderBy('created_at', 'DESC')->first();
            // $title_mail = "Tin sốt dẻo";

            // foreach($this->podcast as $send){
            //     $data['email'][] = $send->email;
            // }
            // Mail::send('email.Newsletter', compact('dataNews'), function ($messager) use ($title_mail, $data){
            //     $messager->to($data['email'])->subject($title_mail);
            //     $messager->from($data['email'], $title_mail);
            // });

            // return response()->json([
            //     "message" => "Gửi mail thành công"
            // ], 200);
    }
}
