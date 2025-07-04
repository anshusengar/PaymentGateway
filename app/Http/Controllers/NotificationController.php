<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function sendToAllUsers()
    {
        // Define the notification details
        $details = [
            'subject' => 'New Admin Announcement!',
            'body' => 'We have some exciting news for you. Check out your dashboard for updates.',
            'url' => url('/dashboard'),
        ];

        // Fetch all users
        $users = User::all(); // Or a more specific query like User::where('role', 'admin')->get()

        // Loop through users and send the notification
        foreach ($users as $user) {
            $user->notify(new NewUserNotification($details));
        }

        return redirect()->back()->with('status', 'Notifications sent to all users!');
    }
}
