<?php

namespace App\Listeners;

use App\Mail\WelcomeMail;
use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Handle the event.
     */
   public function handle(UserRegistered $event)
{
    $user = $event->user;

    Mail::to($user->email)->send(new WelcomeMail($user));
}
}
