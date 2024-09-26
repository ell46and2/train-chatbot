<?php

declare(strict_types=1);

namespace App\Http\Controllers\ChatBot;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ChatBotIndexController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('ChatBot');
    }
}
