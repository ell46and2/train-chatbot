<?php

declare(strict_types=1);

namespace App\Http\Controllers\ChatBot;

use App\Http\Actions\ProcessChatBotMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatBotProcessMessageRequest;
use Illuminate\Http\JsonResponse;
use Throwable;

class ChatBotProcessMessageController extends Controller
{
    public function __invoke(ChatBotProcessMessageRequest $request, ProcessChatBotMessage $processChatBotMessage): JsonResponse
    {
        try {
            $response = $processChatBotMessage->execute($request->getMessage());

            return response()->json([
                'bot_response' => $response
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'bot_response' => 'Error connecting to api. Please try again later.'
            ]);
        }
    }
}
