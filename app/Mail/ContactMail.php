<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $ct = null;
    public function __construct($data)
    {
        $this->ct = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('phuly4795@gmail.com','Thành Phú')
        ->to('phuly4795@gmail.com')
        ->subject('Thư liên hệ')
        ->view('email.contactEmail');
    }
}
