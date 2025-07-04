<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
        $googleUser = Socialite::driver('google')->stateless()->user();
        // Debugging output
        dd($googleUser);

        $googleId = $googleUser->getId();
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->google_id = $googleId;
            $user->save();
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleId,
                'password' => bcrypt('dummy-password'),
            ]);
        }

        Auth::login($user);

        return redirect()->intended('dashboard');
    } 

    
}
