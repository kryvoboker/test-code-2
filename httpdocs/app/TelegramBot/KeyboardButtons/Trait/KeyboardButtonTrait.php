<?php

declare(strict_types = 1);

namespace App\TelegramBot\KeyboardButtons\Trait;

use Longman\TelegramBot\Entities\KeyboardButton;
use Longman\TelegramBot\Entities\Update;

trait KeyboardButtonTrait
{

    /**
     * @param Update $update
     *
     * @return bool
     */
    public function isThisButtonPressed(Update $update) : bool
    {
        return str_starts_with(
            $update->getMessage()?->getText(),
            $this->getName()
        );
    }

    /**
     * @return KeyboardButton
     */
    public function getButton() : KeyboardButton
    {
        return new KeyboardButton($this->getName());
    }
}
