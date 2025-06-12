<?php

declare(strict_types = 1);

namespace App\TelegramBot\Keyboards\Replies;

use App\Contrancts\Telegram\TelegramKeyboardInterface;
use App\TelegramBot\KeyboardButtons\Report\ReportButton;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\Update;

class MainMenuKeyboard implements TelegramKeyboardInterface
{
    /**
     * @inheritDoc
     */
    public function getKeyboard(?Update $update = null) : Keyboard
    {
        $buttons = [
            app(ReportButton::class)->getButton(),
        ];

        return new Keyboard(...$buttons)
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true);
    }
}
