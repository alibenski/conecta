<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConnectNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $user_id;
    public $user_name;
    public $project_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg, $user_id, $user_name, $project_id)
    {
        $this->msg = $msg;
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->project_id = $project_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Conecta Notification')->markdown('emails.connect_notification')
            ->with('msg', $this->msg)
            ->with('user_id', $this->user_id)
            ->with('user_name', $this->user_name)
            ->with('project_id', $this->project_id);
    }
}


