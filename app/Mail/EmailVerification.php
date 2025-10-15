<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;


    public $user_id;
    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $code)
    {
        //

        $this->user_id = $user_id;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Conecta - Verify your Email')->markdown('emails.email_verification')
            ->with('code', $this->code)
            ->with('user_id', $this->user_id);
    }
}
