<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Telegram;

use App\Http\Controllers\Controller;
use App\TelegramBot\BotHandler;
use Longman\TelegramBot\Exception\TelegramException;

class TelegramController extends Controller
{
    public function __construct(
        private readonly BotHandler $telegram_handler
    ) {}

    /**
     * @return void
     * @throws TelegramException
     */
    public function handle() : void
    {
        $this->telegram_handler->handle();
    }
}
