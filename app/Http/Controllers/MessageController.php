<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'from_user_id' => auth()->id(), 
            'to_user_id' => $validated['to_user_id'],
            'message' => $validated['message']
        ]);

        // later we'll broadcast here
        return response()->json($message);
    }
}
