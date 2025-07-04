<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\TestNotification;

class SampleCommand extends Command
{
   

protected $signature = 'sample:command';
    protected $description = 'Send notification to all users';

    public function handle()
    {
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            $user->notify(new TestNotification());
        }

        $this->info('Notification sent to all users.');
    }
}


