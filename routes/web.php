<?php

declare(strict_types=1);

use App\Http\Controllers\ChatBot\ChatBotIndexController;
use App\Http\Controllers\ChatBot\ChatBotProcessMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', ChatBotIndexController::class);
Route::post('/process', ChatBotProcessMessageController::class);
