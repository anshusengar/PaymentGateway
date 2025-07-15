<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Notifications\ClientAnnouncement;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function announcement()
{
    $users = User::all();

    foreach ($users as $user) {
        $user->notify(new ClientAnnouncement('System maintenance scheduled for tomorrow at 9PM.'));
    }

    return 'Notifications sent to all users.';
}


public function users(){
    $users=User::where('role','user')->get();
    return view('user.index',compact('users'));
}
}
