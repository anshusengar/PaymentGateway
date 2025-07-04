@extends('layouts.app')

@section('content')

<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Dashboard Page</h1>

    <p>Welcome to your Dashboard!</p>

    <h3 class="mt-6 text-lg font-semibold">Notifications</h3>

    <ul class="list-disc pl-5">
        @forelse(auth()->user()->notifications as $notification)
            <li class="mb-2">
                {{ $notification->data['body'] ?? 'No message' }}
                <a href="{{ $notification->data['url'] ?? '#' }}" class="text-blue-500 underline ml-2">View</a>
            </li>
        @empty
            <li>No notifications</li>
        @endforelse
    </ul>
</div>

@endsection
