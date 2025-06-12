<?php

declare(strict_types = 1);

namespace App\Services\Api\Telegram;

use Illuminate\Support\Facades\Log;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class ApiTelegramService
{
    /**
     * @param int   $chat_id
     * @param array $params
     *
     * @return ServerResponse|null
     * @throws TelegramException
     */
    public function sendMessage(int $chat_id, array $params) : ?ServerResponse
    {
        $data = [
            'chat_id' => $chat_id,
        ];

        $server_response = Request::sendMessage(array_merge($data, $params));

        if ($server_response->isOk()) {
            return $server_response;
        } else {
            Log::channel('stack')->error(
                'Telegram sendMessage error: ' . $server_response->getDescription(),
                [
                    'error_code' => $server_response->getErrorCode(),
                    'chat_id'    => $chat_id,
                    'params'     => $params,
                ]
            );

            return null;
        }
    }
}
