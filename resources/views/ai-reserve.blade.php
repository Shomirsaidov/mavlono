@extends('layouts.app')

@section('title')
    Mavlono.tj - бехтарин хазинаи ашъори ниёгон
@endsection

@section('content')
<div class="flex items-center justify-center bg-gray-100">
    <div class="w-full flex flex-col h-screen p-2 py-8 md:p-8 bg-white shadow-md rounded-lg space-y-3">


        <div id="message-container" class="custom-scroll-container rounded-md p-8 space-y-3" style="flex: 1; overflow-y: scroll">
            <!-- Existing messages -->

            <div class="flex flex-col justify-center items-center space-y-4">
                <img src="/assets/brand/ai-mascotte.jpg" width="80" class="rounded-full border-2" alt="">
                <div>
                    <h3 class="text-center font-bold text-lg">Сафина (зеҳни сунъӣ)</h3>
                    <h3 class="text-center text-green-600">онлайн</h3>
                </div>
            </div>

        </div>

        <div id="loading-indicator" class="mb-8 hidden flex justify-end items-center">
            <div class="spinner-border animate-spin inline-block w-12 h-12 border-4 border-gray-200 border-t-blue-600 rounded-full" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>


        <div class="flex space-x-2">
            <input type="text" placeholder="Саволро ворид кунед..." id="input-message" class="font-bold p-3 border-2 outline-none rounded-full w-full">
            <button class="rounded-full p-2 px-4" id="send-btn" style="background: #474787;">
                <img src="/assets/send-1.svg" alt="" width="25">
            </button>
        </div>
    </div>
</div>    

<style>
    /* width */
    .custom-scroll-container::-webkit-scrollbar {
      width: 4px;
    }

    /* Track */
    .custom-scroll-container::-webkit-scrollbar-track {
      background: #e2e2e2;
      border-radius: 120px;
    }

    /* Handle */
    .custom-scroll-container::-webkit-scrollbar-thumb {
      background: #474787;
      border-radius: 120px;
    }

    /* Handle on hover */
    .custom-scroll-container::-webkit-scrollbar-thumb:hover {
      background: rebeccapurple;
    }

    .spinner-border {
        border-top-color: transparent;
        border-left-color: transparent;
        border-right-color: transparent;
        border-bottom-color: indigo;
        border-radius: 30px;
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>



document.addEventListener('DOMContentLoaded', async function() {
    // Get query parameter from URL
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query');

    // If query is present, automatically send it
    if (query) {
        const messageInput = document.getElementById('input-message');
        messageInput.value = "Маънои ин шеър чист : " + query;

        // Trigger the send button click only if it's not already in the process
        if (!document.getElementById('send-btn').hasAttribute('data-clicked')) {
            document.getElementById('send-btn').setAttribute('data-clicked', 'true');
            document.getElementById('send-btn').click();
        }

        document.getElementById('input-message').value = '';
    }
});

document.getElementById('send-btn').addEventListener('click', async function() {
    const messageInput = document.getElementById('input-message');
    const message = messageInput.value;
    
    if (message.trim() !== '') {
        // Create new message element for the user
        let newMessageDiv = document.createElement('div');
        newMessageDiv.classList.add('flex', 'justify-end'); // User message alignment

        let userMessageContent = `
            <div class="flex items-start justify-end space-x-3 w-3/4">
                <p class="p-2 bg-indigo-700 text-white rounded-xl">${message}</p>
                <img src="/assets/brand/character_nobg.png" width="40" alt="" class="rounded-full border-2">
            </div>
        `;
        newMessageDiv.innerHTML = userMessageContent;

        // Append user message to the message container
        document.getElementById('message-container').appendChild(newMessageDiv);

        // Clear the input field
        messageInput.value = '';

        // Scroll to the bottom of the container to show the latest message
        let messageContainer = document.getElementById('message-container');
        messageContainer.scrollTop = messageContainer.scrollHeight;

        // Show loading indicator
        document.getElementById('loading-indicator').classList.remove('hidden');

        // Send message to the backend and get response from ChatGPT
        try {
            console.log('api request !');

            const response = await fetch('/ai/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            const botMessage = data.choices[0].message.content;

            // Create new message element for the bot
            let botMessageDiv = document.createElement('div');
            botMessageDiv.classList.add('flex', 'justify-start'); // Bot message alignment

            let botMessageContent = `
                <div class="flex items-start space-x-3 w-3/4">
                    <img src="/assets/brand/ai-mascotte.jpg" width="40" alt="" class="rounded-full border-2">
                    <p class="p-2 bg-gray-200 rounded-xl">${botMessage}</p>
                </div>
            `;
            botMessageDiv.innerHTML = botMessageContent;

            // Append bot message to the message container
            document.getElementById('message-container').appendChild(botMessageDiv);

            // Scroll to the bottom of the container to show the latest message
            messageContainer.scrollTop = messageContainer.scrollHeight;

        } catch (error) {
            console.error('Error:', error);
        } finally {
            // Hide loading indicator
            document.getElementById('loading-indicator').classList.add('hidden');
        }

        // Remove the 'data-clicked' attribute after the message is sent
        document.getElementById('send-btn').removeAttribute('data-clicked');
    }
});

</script>
@endsection
