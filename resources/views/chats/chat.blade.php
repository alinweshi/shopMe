<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/js/app.js'])
    <title>chat</title>
</head>

<body>
    <div class="chat-box" id="chat-box">
        <h3>Chat with {{ $receiver->fullName() }}</h3>

        <!-- Existing messages -->
        @foreach ($messages as $message)
            <div class="message {{ $message->sender_id == auth()->id() ? 'sender' : 'receiver' }}">
                <div class="content">{{ $message->content }}</div>
            </div>
        @endforeach

        <!-- Messages container for new messages -->
        <div id="messagesContainer"></div>

        <!-- Typing indicator -->
        <div class="isTyping" id="isTyping">
            {{ $receiver->first_name }} is typing ...
        </div>

        <!-- Message input form -->
        <div class="message-form" id="message-form">
            <form method="post" action="{{ route('sendMessage', $receiverId) }}">
                @csrf
                <div>
                    <input id="sendContent" type="text" name="content">
                </div>
                <button id="sendButton" type="submit">Send</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            console.log("DOM fully loaded and parsed");

            let senderId = @json(auth()->id());
            console.log("sender id", senderId);
            let receiverId = @json($receiverId);
            let messageContent = document.getElementById('sendContent');
            let isTyping = document.getElementById('isTyping');
            let messageForm = document.getElementById('message-form');
            let chatBox = document.getElementById('chat-box');
            let messagesContainer = document.getElementById("messagesContainer");

            // Handle sending messages
            messageForm.addEventListener('submit', (event) => {
                event.preventDefault();
                let content = messageContent.value.trim();

                if (content === "") return; // Prevent empty messages

                fetch(`/send-message/${receiverId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            message: content,
                            sender_id: senderId,
                            receiver_id: receiverId,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Message sent:', data);
                    })
                    .catch(error => {
                        console.error('Error sending message:', error);
                    });

                // Append new message
                const messageDiv = document.createElement('div');
                messageDiv.className = "message sender"; // Align to right (sender)
                messageDiv.innerHTML = `<div class="content">${content}</div>`;

                messagesContainer.appendChild(messageDiv);
                chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to latest message
                messageContent.value = ''; // Clear input field
            });

            // Move Echo Listener inside DOMContentLoaded
            if (window.Echo) {
                console.log(`Listening to private-chat.${receiverId}`);
                window.Echo.private(`chat.${receiverId}`).listen('.chat.message', (e) => {
                    console.log('Message received:', e);

                    // Append new message
                    const messageDiv = document.createElement('div');
                    messageDiv.className = "message receiver"; // Align to left (receiver)
                    messageDiv.innerHTML = `<div class="content">${e.message.content}</div>`;

                    messagesContainer.appendChild(messageDiv);
                    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to latest message
                });
            } else {
                console.error("Echo is not loaded. Ensure Pusher is correctly initialized.");
            }
        });
    </script>

</body>
<style>
    .chat-box {
        max-width: 600px;
        margin: auto;
        margin-top: 20px;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        overflow-y: auto;
        /* Enable vertical scrolling */
        height: 70vh;
        /* Set a fixed height for the chat box */
        display: flex;
        flex-direction: column;
    }

    #messagesContainer {
        flex-grow: 1;
        /* Allow messages container to grow and fill available space */
        /* Enable scrolling for messages */
    }

    .message {
        margin: 10px;
        padding: 10px;
        border-radius: 10px;
        max-width: 60%;
    }

    .sender {
        margin-left: auto;
        /* Align to the right */
        text-align: right;
        background-color: #dcf8c6;
        /* Light green for sender */
    }

    .receiver {
        margin-right: auto;
        /* Align to the left */
        text-align: left;
        background-color: #f1f1f1;
        /* Light gray for receiver */
    }

    .content {
        word-wrap: break-word;
    }

    .isTyping {
        display: none;
        /* Hide typing indicator by default */
    }

    #sendContent {
        width: 200px;
        border: solid 2px;
        background-color: rgba(241, 241, 241, 0.71);
        color: rgba(37, 16, 9, 0.66);
        border-color: rgba(241, 241, 241, 0.8);
    }

    #sendButton {
        width: 200px;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>

</html>
