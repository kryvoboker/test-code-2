<?php

declare(strict_types = 1);

namespace App\Contrancts\Telegram;

use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\Update;

interface TelegramKeyboardButtonInterface
{
    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @param Update $update
     *
     * @return bool
     */
    public function isThisButtonPressed(Update $update) : bool;

    /**
     * @return KeyboardButton
     */
    public function getButton() : KeyboardButton;

    /**
     * @param Update $update
     *
     * @return void
     */
    public function handle(Update $update) : void;
}
