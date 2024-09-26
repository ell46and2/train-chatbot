<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatBotProcessMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => [
                'required',
                'string',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function getMessage(): string
    {
        return $this->string('message')->toString();
    }
}
