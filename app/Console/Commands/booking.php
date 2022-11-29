<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class booking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $email = User::where('id', 27)->first();
        $e = $email->email;
        Mail::send('email.test',compact('email'), function ($email) use ($e) {
            $email->from('phuly4795@gmail.com','Fpro Hopital');
            $email->subject('Fpro Hopital - Trả lời liên hệ');
            $email->to($e, 'Quý khách');
        });


    }
}
