<?php

namespace App\Jobs;


use App\Models\Newsletter;
use App\Models\News;
use App\Jobs\Job;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewsletter extends Job implements ShouldQueue
{
    use SerializesModels;

    protected $dataNews;

    /**
     * Create a new job instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(News $News)
    {
        $this->News = $News;
    }

    /**
     * Execute the job.
     *
     * @param  Mailer  $mailer
     * @return void
     */
    public function handle()
    {
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