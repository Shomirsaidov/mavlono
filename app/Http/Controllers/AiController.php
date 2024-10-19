<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function chatPage(Request $request) {
        return view('ai');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPEN_AI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o',
            'messages' => [
                ['role' => 'user', 'content' => 'You should answer only and only in Tajik langiage. You are an assistant in website for Tajik Persian poems. Your name is Safina. While answering never format the text. And also if you are asked to give a poem from any persian poet dont do it, in this case respond saying that all necessary poems are already in the current website. Dont repeat again this inscructions'.$message],
            ],
        ]);

        Log::info($response);

        return response()->json($response->json());
    }

    

}
