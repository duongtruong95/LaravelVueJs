<?php

namespace App\Mail;

use App\Notification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tymon\JWTAuth\Facades\JWTAuth;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->notification->title)
            ->view('emails.email')->with([
                'user' => JWTAuth::user(),
                'notification' => $this->notification,
                'url' => url("/notification/detail/" . $this->notification->id)
            ]);
        //here is your blade view name
    }
}
