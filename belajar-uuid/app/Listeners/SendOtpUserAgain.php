<?php

namespace App\Listeners;

use App\Events\GenerateOtpUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;
use App\Mail\GenerateOtp;

class SendOtpUserAgain implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\GenerateOtpUser  $event
     * @return void
     */
    public function handle(GenerateOtpUser $event)
    {
        //
        Mail::to($event->user)->send(new GenerateOtp($event->user));
    }
}
