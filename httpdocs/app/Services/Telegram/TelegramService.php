<?php

declare(strict_types = 1);

namespace App\Services\Telegram;

use App\Services\User\UserService;
use Longman\TelegramBot\Entities\Keyboard;

readonly class TelegramService
{
    public function __construct(
        private UserService $user_service
    ) {}

    /**
     * @return array
     */
    public function getTelegramMessageParamsByValidationUserBlocked() : array
    {
        if ($this->user_service->isBlocked()) {
            return [
                'text'         => __('user/index.error_user_blocked'),
                'reply_markup' => Keyboard::remove(),
            ];
        }

        return [];
    }
}
