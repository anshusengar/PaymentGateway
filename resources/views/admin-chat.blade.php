@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Admin Chat Test</h3>
    <div id="messages" style="border: 1px solid #ddd; padding: 10px; min-height: 200px;">
        <p>Waiting for messages...</p>
    </div>
    <input type="text" id="messageInput" placeholder="Type a test message">
    <button id="sendMessage">Send Test Message</button>
</div>
@endsection

@section('scripts')
<script>
    const userId = {{ auth()->id() }};

    Echo.private(`chat.${userId}`)
        .listen('NewMessage', (e) => {
            console.log("New message received: ", e.message);
            const messages = document.getElementById('messages');
            messages.innerHTML += `<p><b>${e.message.from_user_id}</b>: ${e.message.message}</p>`;
        });

   document.getElementById("sendMessage").addEventListener("click", function() {
    const msg = document.getElementById("messageInput").value;

    fetch("/messages", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            to_user_id: 2, // hardcoded to user 2
            message: msg
        })
    }).then(res => res.json()).then(data => {
        console.log("Sent", data);
    });
});

</script>
@endsection
