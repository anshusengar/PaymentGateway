<?php

use App\Models\tblclients;
use App\Mail\WelcomeClientMail;
use Illuminate\Support\Facades\Mail;

class SendBulkWelcomeEmails implements ShouldQueue
{
    public function handle()
    {
        $clients = tblclients::where('status', 'active')->get();

        foreach ($clients as $client) {
            Mail::to($client->email)
                ->queue(new WelcomeClientMail($client)); // queue inside the job
        }
    }
}
