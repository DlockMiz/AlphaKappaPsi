<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SignedEventEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $obj;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
        return $this->build();
    }

    /**
     * Build the message.
     *
     * @return $this
    */
    public function build()
    {
        return $this->subject($this->obj->event_title)
                    ->view('signed_users_email');
    }
}
