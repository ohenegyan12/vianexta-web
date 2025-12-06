<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        // Validate the API key
        if ($request->header('X-API-Key') !== config('services.chat.api_key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                'Content-Type' => 'application/json',
            ])->post(config('services.openai.url'), [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $request->message]
                ],
            ]);

            if ($response->successful()) {
                return response()->json([
                    'response' => $response->json()['choices'][0]['message']['content']
                ]);
            }
            dd($response->json());

            return response()->json(['error' => 'OpenAI API request failed'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
