@extends('layouts.app')

@section('title')
    Сафина - ёвари шумо дар mavlono.tj
@endsection

@section('content')
<div class="flex items-center justify-center bg-gray-100">
    <div class="w-full flex flex-col h-screen p-2 py-8 md:p-8 bg-white shadow-md rounded-lg space-y-3">
        <div id="message-container" class="custom-scroll-container border-2 rounded-md p-8 space-y-3" style="flex: 1; overflow-y: scroll">
            <!-- Existing messages -->

            <div class="flex flex-col justify-center items-center space-y-4">
                <img src="/assets/brand/ai-mascotte.jpg" width="80" class="rounded-full border-2" alt="">
                <div>
                    <h3 class="text-center font-bold text-lg">Сафина (зеҳни сунъӣ)</h3>
                    <h3 class="text-center text-green-600">онлайн</h3>
                </div>
            </div>

        </div>

        

        <div class="flex space-x-2">
            <!-- Input field and send button -->
            <input type="text" placeholder="Саволро ворид кунед..." id="input-message" class="font-bold p-3 border-2 outline-none rounded-full w-full">
            <button class="rounded-full p-2 px-4" id="send-btn" style="background: #474787;">
                <img src="/assets/send-1.svg" alt="" width="25">
            </button>
            <button id="start-speech" class="border-2 text-xl border-indigo-800 text-white font-bold p-2 px-3 rounded-full">
                🎤
            </button>
            <div id="loading-indicator" class="hidden flex justify-end">
                <div class="loader"></div>
            </div>
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

    /* Simple loading indicator (spinner) */
    .loader {
        border: 4px solid #f3f3f3;
        border-top: 8px solid #474787;
        border-radius: 50%;
        width: 50px;
        height: 50px;
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
        document.getElementById('send-btn').click();
    }
});

// Add event listener to the send button
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
    }
});

// Speech recognition setup
const startSpeechButton = document.getElementById('start-speech');
const messageInput = document.getElementById('input-message');

if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = new SpeechRecognition();

    recognition.lang = 'fa_Ir'; // Set the language to Tajik (or adjust as needed)
    recognition.continuous = false;
    recognition.interimResults = false;

    // Start speech recognition when the button is clicked
    startSpeechButton.addEventListener('click', function() {
        recognition.start();
        console.log("Speech recognition started...");
    });

    // On result (speech is recognized)
    recognition.onresult = async function(event) {
        const transcript = event.results[0][0].transcript;


        await fetch('https://api.openai.com/v1/chat/completions', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer {{ env('OPEN_AI_API_KEY') }}`
            },
            body: JSON.stringify({
                model: 'gpt-4o',  // Specify the model you want to use (e.g., 'gpt-4' or 'gpt-3.5-turbo')
                messages: [
                { role: 'system', content: 'твоя задача получить этот персидский текст и просто сделать транлитерацию на таджикский не переводя и не добавляя своих слов, но твоя формулировка на таджикском должны быть правильной по меркам таджикских слов, сформулируй правильное таджикское предложение, не забудь добавлять окончание "и" когда это надо, ты часто это забываешь. никогда не меняй слова полностью. затем отправь мне только и только транлитерацию. ничего больше не добавляй. текст исключительно на таджикской кириллице, тебе нельзя отвечать латинскими буквами !' },
                { role: 'user', content: transcript }
                ]
            })
            
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.choices[0].message.content)
            var tajikText = data.choices[0].message.content
            messageInput.value = tajikText;
            document.getElementById('send-btn').click(); // Send the recognized speech as a message
        }) // The response from the API
        .catch(error => console.error('Error:', error));


       
    };

    // Handle recognition errors
    recognition.onerror = function(event) {
        console.error("Speech recognition error:", event.error);
    };

    // Handle recognition end
    recognition.onend = function() {
        console.log("Speech recognition ended.");
    };
} else {
    console.error("Speech recognition not supported in this browser.");
}
</script>
@endsection
