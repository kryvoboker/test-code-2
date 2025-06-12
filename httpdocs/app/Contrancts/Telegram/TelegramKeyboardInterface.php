<?php

declare(strict_types = 1);

namespace App\Contrancts\Telegram;

use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\Update;

interface TelegramKeyboardInterface
{
    /**
     * @param Update|null $update
     *
     * @return Keyboard
     */
    public function getKeyboard(?Update $update = null) : Keyboard;
}
