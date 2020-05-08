<?php

namespace App\Jobs;

use App\Mail\MailNotify;
use App\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 3;
    protected $notification;
    protected $arrEmail;

    public function __construct(Notification $notification, $arrEmail = array())
    {
        $this->notification = $notification;
        $this->arrEmail = $arrEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $email = new MailNotify($this->notification);
            Mail::to($this->arrEmail)->send($email);
        } catch (Exception $e) {
            Log::error($e->getLine() . $e->getCode() . $e->getMessage());
        }
    }
}
